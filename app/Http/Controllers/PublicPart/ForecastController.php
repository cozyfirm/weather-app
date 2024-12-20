<?php

namespace App\Http\Controllers\PublicPart;

use App\Http\Controllers\Controller;
use App\Models\Base\Cities;
use App\Models\Users\History\SearchHistory;
use App\Traits\API\ForecastTrait;
use App\Traits\API\LocationsTrait;
use App\Traits\Http\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ForecastController extends Controller{
    use ResponseTrait, LocationsTrait, ForecastTrait;

    protected string $_path = 'public-part.app.forecast.';

    /**
     * Search cities from API by keyword
     * @return View
     */
    public function search(): View{
        return view($this->_path . 'search');
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
            $city = $this->createCityObject($cityKey, $cityResponse, true);

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
     * @param $citiKey
     * @return View
     */
    public function preview($citiKey): View{
        $day = $this->getDayInfo($citiKey);
        /* Log search history */
        $this->userSearchHistory($citiKey);

        return view($this->_path . 'preview', [
            'day' => $day,
            'history' => $this->getUserHistory()
        ]);
    }
    public function previewDay(): View{
        return view($this->_path . 'preview-day');
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
