<?php

namespace App\Http\Controllers\PublicPart;

use App\Http\Controllers\Controller;
use App\Models\Base\Cities;
use App\Models\Base\Forecast\FiveDays;
use App\Models\Base\Forecast\FiveDaysInfo;
use App\Models\Users\History\SearchHistory;
use App\Traits\API\ForecastTrait;
use App\Traits\API\LocationsTrait;
use App\Traits\Http\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
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

        if($city->twelveHoursRel->count() < 13){
            /* Get twelve hours info */
            $this->saveTwelveHoursForecast($cityKey);
        }
        if($city->fiveDaysRel->count() < 5){
            $this->saveFiveDaysForecast($cityKey);
        }

        return $city;
    }

    /**
     * Get user search history by cities
     * @param $cityKey
     * @return void
     */
    public function userSearchHistory($cityKey): void{
        $history = SearchHistory::where('city_key', '=', $cityKey)->where('ip_addr', '=', request()->ip())->first();
        if(!$history){
            SearchHistory::create(['city_key' => $cityKey, 'ip_addr' => request()->ip(), 'loads' => '1']);
        }else{
            $history->update(['loads' => ($history->loads + 1)]);
        }
    }
    /**
     * Preview info about day
     *
     * @param $cityKey
     * @return View
     */
    public function preview($cityKey): View{
        $city = $this->getDayInfo($cityKey);
        /* Update number of loads */
        $city->update(['loads' => ($city->loads + 1)]);

        /* Log search history */
        $this->userSearchHistory($cityKey);

        return view($this->_path . 'preview', [
            'city' => $city,
            'history' => $this->getUserHistory(),
            'dateTime' => $this->getFullDateTime(Carbon::now())
        ]);
    }
    public function previewDay($cityKey, $date, $type): View{
        $city = $this->getDayInfo($cityKey);

        if(date("Y-m-d", strtotime('today')) == $date) $dayTitle = "danas";
        else if(date("Y-m-d", strtotime('tomorrow')) == $date) $dayTitle = "sutra";
        else $dayTitle = $this->getMDayY($date);

        $fiveDays = FiveDays::where('city_key', '=', $cityKey)->where('date', '=', $date)->first();
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
