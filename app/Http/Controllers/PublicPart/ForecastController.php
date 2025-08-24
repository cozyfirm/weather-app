<?php

namespace App\Http\Controllers\PublicPart;

use App\Http\Controllers\Controller;
use App\Models\Base\Cities;
use App\Models\Base\Forecast\FiveDays;
use App\Models\Base\Forecast\FiveDaysInfo;
use App\Models\Base\Forecast\TwelveHours;
use App\Models\Users\History\SearchHistory;
use App\Traits\API\ForecastTrait;
use App\Traits\API\LocationsTrait;
use App\Traits\Http\ResponseTrait;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ForecastController extends Controller{
    use ResponseTrait, LocationsTrait, ForecastTrait;

    protected string $_path = 'public-part.app.forecast.';

    /**
     * Search cities from API by keyword
     * @return View
     */
    public function search($keyword): View{
        $cities = $this->searchBy("cities/autocomplete", $keyword);
        $popular = Cities::where('base', '=', 1)->inRandomOrder()->take(4)->get();

        return view($this->_path . 'search', [
            'cities' => $cities,
            'history' => $this->getUserHistory(),
            'popular' => $popular
        ]);
    }

    public function getMyCity(): RedirectResponse{
        try{
            $ip = request()->ip();
            // $ip = "77.78.226.106";

            $client = new Client();

            try {
                $response = $client->request('GET', env('ACCU_WEATHER_BASE_URI') . 'locations/v1/cities/ipaddress' , [
                    'query' => $this->constructQuery($ip, "bs")
                ]);

                if($response->getStatusCode() == 200) $response = json_decode($response->getBody());
                else return redirect()->route('public.home');

                return redirect()->route('public.forecast.preview', ['cityKey' => $response->Key]);
            } catch (GuzzleException $e) {
                return redirect()->route('public.home');
            }
        }catch (\Exception $e){
            return redirect()->route('public.home');
        }
    }

    /** ------------------------------------------------------------------------------------------------------------ **/
    /**
     * @param $cityKey
     * @return mixed
     */
    public function getDayInfo($cityKey): mixed {
        $city = Cities::where('key', '=', $cityKey)->first();

        if(!$city){
            /* In case there is no city info, let's first create one */

            $cityResponse = $this->searchBy($cityKey, null);
            $city = $this->createCityObject($cityKey, $cityResponse);

            /* Get twelve hours info */
            $this->saveTwelveHoursForecast($cityKey);

            /* Get five days forecast */
            $this->saveFiveDaysForecast($cityKey);

            return $city;
        }

        /**
         *  Update forecast on every request
         */
        $this->saveTwelveHoursForecast($cityKey);
        $this->saveFiveDaysForecast($cityKey);

        if($city->twelveHoursRel->count() < 13 or $city->fiveDaysRel->count() < 5){
            if($city->twelveHoursRel->count() < 13){
                /* Get twelve hours info */
            }
            if($city->fiveDaysRel->count() < 5){ }

            return null;
        }

        return Cities::where('key', '=', $cityKey)->first();
    }

    /**
     * Get user search history by cities
     * @param $cityKey
     * @param $slug
     * @return void
     */
    public function userSearchHistory($cityKey, $slug): void{
        $history = SearchHistory::where('city_key', '=', $cityKey)->where('ip_addr', '=', request()->ip())->first();
        if(!$history){
            SearchHistory::create(['city_key' => $cityKey, 'slug' => $slug, 'ip_addr' => request()->ip(), 'loads' => '1']);
        }else{
            $history->update(['loads' => ($history->loads + 1)]);
        }
    }

    public function getCityInfo($city): View{
        /* Update number of loads */
        $city->update(['loads' => ($city->loads + 1)]);

        /* Log search history */
        $this->userSearchHistory($city->key, $city->slug);

        $twelveHours = $city->twelveHoursRel;

        try{
            /* Get info about sunset and sunrise */
            $today = FiveDays::where('city_key', '=', $city->key)->where('date', '=', date('Y-m-d'))->first();
            $tomorrow = FiveDays::where('city_key', '=', $city->key)->where('date', '=', Carbon::now()->addDay()->format('Y-m-d'))->first();

            $sunrise = null;
            $sunset  = null;

            $startOfInterval = Carbon::parse($twelveHours[0]->date_time ?? '');
            $endOfInterval   = Carbon::parse($twelveHours[$twelveHours->count() -1 ]->date_time ?? '');

            $todaySunrise = Carbon::parse($today->sunrise);
            $todaySunset  = Carbon::parse($today->sunset);

            $tomorrowSunrise = Carbon::parse($tomorrow->sunrise);
            $tomorrowSunset  = Carbon::parse($tomorrow->sunset);

            if($todaySunrise >= $startOfInterval and $todaySunrise <= $endOfInterval){
                $sunrise = $todaySunrise;
            }else if($todaySunset >= $startOfInterval and $todaySunset <= $endOfInterval){
                $sunset = $todaySunset;
            }else if($tomorrowSunrise >= $startOfInterval and $tomorrowSunrise <= $endOfInterval){
                $sunrise = $tomorrowSunrise;
            }else if($tomorrowSunset >= $startOfInterval and $tomorrowSunset <= $endOfInterval){
                $sunset = $tomorrowSunset;
            }

            if(isset($sunrise)){
                $sunriseSample = new TwelveHours();
                $sunriseSample->date_time = $sunrise->format('Y-m-d H:i:s');
                $sunriseSample->icon = "sunrise";

                $twelveHours->push($sunriseSample);
                $twelveHours = $twelveHours->sortBy(function($model){ return $model->date_time; });
            }
            if(isset($sunset)){
                $sunsetSample = new TwelveHours();
                $sunsetSample->date_time = $sunset->format('Y-m-d H:i:s');
                $sunsetSample->icon = "sunset";

                $twelveHours->push($sunsetSample);
                $twelveHours = $twelveHours->sortBy(function($model){ return $model->date_time; });
            }

        }catch (\Exception $e){}

        return view($this->_path . 'preview', [
            'city' => $city,
            'history' => $this->getUserHistory(),
            'dateTime' => $this->getFullDateTime(Carbon::now()),
            'twelveHours' => $twelveHours
        ]);
    }
    /**
     * Preview info about day
     *
     * @param $cityKey
     * @return View
     */
    public function preview($cityKey): RedirectResponse{
        $city = $this->getDayInfo($cityKey);
        if(!$city) $city = Cities::where('key', '=', $cityKey)->first();

        // Not so clever solution, but it's what it is
        return redirect()->route('public.forecast.preview-by-slug', ['slug' => $city->slug]);
    }

    /**
     * Get City by slug;
     *
     * @param $slug
     * @return View
     */
    public function previewBySlug($slug): View{
        $dbCity = Cities::where('slug', '=', $slug)->first();

        $city = $this->getDayInfo($dbCity->key);
        if(!$city) $city = Cities::where('key', '=', $dbCity->key)->first();

        return $this->getCityInfo($city);
    }

    /** ------------------------------------------------------------------------------------------------------------- */
    /**
     *  Five days info
     */

    public function previewFiveDays($city, $date, $type): View{
        if(date("Y-m-d", strtotime('today')) == $date){
            if($type == 'night') $dayTitle = "večeras";
            else $dayTitle = "danas";
        }
        else if(date("Y-m-d", strtotime('tomorrow')) == $date) {
            if($type == 'night') $dayTitle = "sutra večer";
            else $dayTitle = "sutra";
        }
        else $dayTitle = $this->getMDayY($date);

        $fiveDays = FiveDays::where('city_key', '=', $city->key)->where('date', '=', $date)->first();
        $info = FiveDaysInfo::where('parent_id', '=', $fiveDays->id)->where('type', '=', $type)->first();

        return view($this->_path . 'preview-day', [
            'city' => $city,
            'date' => $date,
            'history' => $this->getUserHistory(),
            'dayTitle' => $dayTitle,
            'dayName' => $this->getDay($date),
            'type' => $type,
            'fiveDays' => $fiveDays,
            'info' => $info,
            'previewDay' => true
        ]);
    }

    public function previewDay($cityKey, $date, $type): View{
        $city = $this->getDayInfo($cityKey);
        if(!$city) $city = Cities::where('key', '=', $cityKey)->first();

        return $this->previewFiveDays($city, $date, $type);
    }

    public function dailyBySlug($slug, $date, $type): View{
        $dbCity = Cities::where('slug', '=', $slug)->first();

        $city = $this->getDayInfo($dbCity->key);
        if(!$city) $city = Cities::where('key', '=', $dbCity->key)->first();

        return $this->previewFiveDays($city, $date, $type);
    }

    /** ------------------------------------------------------------------------------------------------------------ **/
    /**
     *  API routes
     */
    public function searchByText(Request $request): JsonResponse{
        try{
            $jsonResponse = [];
            if(isset($request->term)) {
                $response = $this->searchBy("cities/autocomplete", $request->term);

                foreach($response as $data){
                    $jsonResponse[] = [
                        'id' => $data->Key,
                        'title' => $data->LocalizedName,
                        'description' => $data->Country->LocalizedName ?? ''
                    ];
                }
            }else{
                return $this->apiResponse('5020', __('Uneseni podaci nisu validni'));
            }

            return $this->apiResponse('0000', __('Success'), [
                'data' => $jsonResponse
            ]);

        }catch (\Exception $e){
            Log::channel('api')->info($e->getMessage());
            return $this->apiResponse('5000', __('Greška prilikom pretraživanja!!'));
        }
    }
}
