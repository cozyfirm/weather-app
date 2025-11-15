<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use \App\Http\Controllers\PublicPart\ForecastController as PublicForecastController;
use App\Models\Base\Cities;
use App\Models\Base\Forecast\FiveDays;
use App\Models\Base\Forecast\FiveDaysInfo;
use App\Models\Base\Forecast\TwelveHours;
use App\Traits\API\ForecastTrait;
use App\Traits\Common\CommonTrait;
use App\Traits\Common\LogTrait;
use App\Traits\Http\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use temperatureHelper;
use WindHelper;

class ForecastController extends Controller{
    use ResponseTrait, LogTrait, CommonTrait, ForecastTrait;

    protected string $_time_of_day = 'day';

    /**
     * Get popular cities with temperatures and icons
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function popularCities(Request $request): JsonResponse{
        try{
            $cities = Cities::where('base', '=', 1)
                ->orderBy('name')
                ->take(6)
                ->with('twelveHoursCurrentRel:id,city_key,temperature,icon')
                ->get(['id', 'key', 'slug', 'name']);

            return $this->apiResponse('0000', __('Success'), [
                'cities' => $cities
            ]);
        }catch (\Exception $e){
            $this->write('ForecastController::popularCities()', $e->getCode(), $e->getMessage(), $request);
            return $this->apiResponse('3000', __('Greška prilikom obrade zahtjeva. Molimo kotantktirajte administratora!'));
        }
    }

    /** ------------------------------------------------------------------------------------------------------------- */

    /**
     * Get five days forecast; Preview 5 days with basic info
     * @param $city
     * @return array
     */
    public function getFiveDaysForecast($city): array{
        $fiveDaysForecast = [];

        foreach ($city->fiveDaysRel as $day){
            $fiveDaysForecast[] = [
                'id' => $day->id,
                'cityKey' => $day->city_key,
                'date' => $day->date,
                'dateAndMonth' => $day->dateAndMonth(),
                'weekDay' => $day->weekDay(),
                'icon' => env('APP_URL') . ('/files/images/weathericons/') . ( $day->dayRel->icon ?? '1' ) . (".png"),
                'minTemp' => ((temperatureHelper::roundUp($day->min_temp ?? '0')) . ("°C")),
                'maxTemp' => ((temperatureHelper::roundUp($day->max_temp ?? '0')) . ("°C")),
                'winDirection' => $day->dayRel->wind_direction_l ?? '',
                'windSpeed' => $day->dayRel->wind_speed ?? ''
            ];
        }

        return $fiveDaysForecast;
    }

    /**
     * Get wind direction; Used in ForecastController::previewCity(Request $request);
     *
     * @param $city
     * @return array
     */
    public function getInitWindDirection($city): array{
        return [
            'angle' => $city->twelveHoursCurrentRel->wind_direction_deg ?? '0',
            'direction' => (("Iz pravca ") . ($city->twelveHoursCurrentRel->wind_direction_l ?? 'I') . ( "(" . ($city->twelveHoursCurrentRel->wind_direction_deg ?? 'I') . "°)" )),
            'windSpeed' =>  $city->twelveHoursCurrentRel->wind_speed ?? '0km/h',
            'windGust' => $city->twelveHoursCurrentRel->wind_gust_speed ?? '0km/h',
            'windSpeedInfo' => WindHelper::windSpeed($city->twelveHoursCurrentRel->wind_speed ?? '0'),
            'windGustInfo' => WindHelper::windGustSpeed($city->twelveHoursCurrentRel->wind_gust_speed ?? '0'),
        ];
    }

    /**
     * Get wind info by day
     * @param $info
     * @return array
     */
    public function getWindInfoByDay($info): array{
        return [
            'angle' => $info->wind_direction_deg ?? '0',
            'direction' => (("Iz pravca ") . ($info->wind_direction_l ?? 'I') . ( "(" . ($info->wind_direction_deg ?? 'I') . "°)" )),
            'windSpeed' =>  $info->wind_speed ?? '0km/h',
            'windGust' => $info->wind_gust_speed ?? '0km/h',
            'windSpeedInfo' => WindHelper::windSpeed($info->wind_speed ?? '0'),
            'windGustInfo' => WindHelper::windGustSpeed($info->wind_gust_speed ?? '0'),
        ];
    }

    /**
     * Preview city basic info by slug
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function previewCity(Request $request): JsonResponse{
        try{
            // Check for slug
            if(!isset($request->slug)) return $this->apiResponse('3051', __('Nepoznat grad'));
            // Find city by slug in database
            $dbCity = Cities::where('slug', '=', $request->slug)->first();
            // Check for valid slug
            if(!$dbCity) return $this->apiResponse('3052', __('Nepoznat grad'));

            /** Now, let's fetch fresh data from city */
            $publicFC = new PublicForecastController();

            $city = $publicFC->getDayInfo($dbCity->key);
            if(!$city) $city = Cities::where('key', '=', $dbCity->key)->first();

            /* Update number of loads */
            $city->update(['loads' => ($city->loads + 1)]);

            /* Log search history */
            $publicFC->userSearchHistory($city->key, $city->slug);

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

            }catch (\Exception $e){
                $this->write('ForecastController::popularCities() - Sunset & Sunrise', "3053", "Greška prilikom detekcije izlaska i zalaska sunca");
            }

            return $this->apiResponse('0000', __('Success'), [
                'info' => [
                    'cityName' => $city->name,
                    'dateTime' => $this->getFullDateTime(Carbon::now()),
                    'description' => $city->twelveHoursCurrentRel->phase ?? '',
                    'icon' => env('APP_URL') . ('/files/images/weathericons/') . ( $city->twelveHoursCurrentRel->icon ?? '1' ) . (".png"),
                    'temperature' => temperatureHelper::roundUp($city->twelveHoursCurrentRel->temperature ?? '0') . ("°C"),
                    'realFeel' => temperatureHelper::roundUp($city->twelveHoursCurrentRel->temperature_rf ?? '0') . ("°C"),
                    'windSpeed' => (($city->twelveHoursCurrentRel->wind_speed ?? '') . (" km/h")),
                    'humidity' => (($city->twelveHoursCurrentRel->rel_humidity ?? '') . (" %")),
                    'visibility' => (($city->twelveHoursCurrentRel->visibility ?? '') . (" km")),
                    'devPoint' => (($city->twelveHoursCurrentRel->dev_point ?? '') . ("°C"))
                ],
                "fiveDaysForecast" => $this->getFiveDaysForecast($city),
                "windDirection" => $this->getInitWindDirection($city),
                "twelveHoursForecast" => $twelveHours,
                // 'city' => $city,
                // 'history' => $this->getUserHistory()
            ]);
        }catch (\Exception $e){
            $this->write('ForecastController::previewCity()', $e->getCode(), $e->getMessage(), $request);
            return $this->apiResponse('3050', __('Greška prilikom obrade zahtjeva. Molimo kotantktirajte administratora!'));
        }
    }

    /**
     * Preview city info by date and time of day (day or night)
     * @param Request $request
     * @return JsonResponse
     */
    public function previewByDate(Request $request): JsonResponse{
        try{
            // Check for slug
            if(!isset($request->slug)) return $this->apiResponse('3061', __('Nepoznat grad'));
            if(!isset($request->date)) return $this->apiResponse('3062', __('Nepoznat datum'));
            if(!isset($request->timeofday)) return $this->apiResponse('3063', __('Nepoznato doba dana'));

            // Set time of day as day or night
            if($request->timeofday == 'night') $this->_time_of_day = 'night';

            // Find city by slug in database
            $dbCity = Cities::where('slug', '=', $request->slug)->first();
            // Check for valid slug
            if(!$dbCity) return $this->apiResponse('3064', __('Nepoznat grad'));

            /** Now, let's fetch fresh data from city */
            $publicFC = new PublicForecastController();

            $city = $publicFC->getDayInfo($dbCity->key);
            if(!$city) $city = Cities::where('key', '=', $dbCity->key)->first();

            if(date("Y-m-d", strtotime('today')) == $request->date){
                if($this->_time_of_day == 'night') $dayTitle = "večeras";
                else $dayTitle = "danas";
            }
            else if(date("Y-m-d", strtotime('tomorrow')) == $request->date) {
                if($this->_time_of_day == 'night') $dayTitle = "sutra večer";
                else $dayTitle = "sutra";
            }
            else $dayTitle = $this->getMDayY($request->date);

            $fiveDays = FiveDays::where('city_key', '=', $city->key)->where('date', '=', $request->date)->first();
            $info = FiveDaysInfo::where('parent_id', '=', $fiveDays->id)->where('type', '=', $request->timeofday)->first();

            return $this->apiResponse('0000', __('Success'), [
                'info' => [
                    'params' => [
                        'slug' => $city->slug,
                        'timeOfDay' => $request->timeofday,
                        'date' => $request->date,
                    ],
                    // City info
                    'cityName' => $city->name,
                    'icon' => env('APP_URL') . ('/files/images/weathericons/') . ( $info->icon ?? '1' ) . (".png"),

                    // Additional weather info
                    'dayTitle' => $dayTitle,
                    'dayName' => $this->getDay($request->date),
                    'dayDate' => $request->date,

                    // Sunrise and sunset info
                    'sunrise' => $fiveDays->getSunrise(),
                    'sunset' => $fiveDays->getSunset(),
                    'sunriseSunsetDesc' => (("Izlazak sunca u ") . ($fiveDays->getSunrise()) . ("h, zalazak u ") . ($fiveDays->getSunset()) . ("h")),

                    // Temperature info
                    'min_temp' => temperatureHelper::roundUp($fiveDays->min_temp ?? '0') . ("°C"),
                    'max_temp' => temperatureHelper::roundUp($fiveDays->max_temp ?? '0') . ("°C"),
                    'longPhrase' => $info->long_phrase ?? '',

                    // Real feel temperature info
                    'real_feel_min' => (temperatureHelper::roundUp($fiveDays->min_temp_rf ?? '0') . ("°C")),
                    'real_feel_max' => (temperatureHelper::roundUp($fiveDays->max_temp_rf ?? '0') . ("°C")),
                    'weatherMetrics' => [
                        'humidity' => (($info->rel_humidity_avg ?? '0') . ("%")),
                        'uvIndex' => [
                            'value' => $fiveDays->uv_index ?? '',
                            'description' => $fiveDays->uv_index_desc ?? ''
                        ],
                        'precipitation' => $info->precipitation_probability ?? '0',
                        'rain' => [
                            'probability' => $info->rain_probability ?? '',
                            'unit' => 'mm'
                        ],
                        'snow' => [
                            'probability' => $info->snow_probability ?? '0',
                            'total' => $info->total_snow ?? '0',
                            'unit' => 'cm'
                        ]
                    ]
                ],
                "fiveDaysForecast" => $this->getFiveDaysForecast($city),
                "windDirection" => $this->getWindInfoByDay($info),
            ]);
        }catch (\Exception $e){
            $this->write('ForecastController::previewByDate()', $e->getCode(), $e->getMessage(), $request);
            return $this->apiResponse('3060', __('Greška prilikom obrade zahtjeva. Molimo kotantktirajte administratora!'));
        }
    }

    public function getCitySlug(Request $request): JsonResponse{
        try{
            // Check for city key
            if(!isset($request->cityKey)) return $this->apiResponse('3071', __('Nepoznat ključ'));

            /** Now, let's fetch fresh data from city */
            $publicFC = new PublicForecastController();

            $city = $publicFC->getDayInfo($request->cityKey);
            if(!$city) $city = Cities::where('key', '=', $request->cityKey)->first();

            return $this->apiResponse('0000', __('Success'), [
                'city' => [
                    'slug' => $city->slug,
                    'name' => $city->name,
                    'region' => $city->region,
                    'country' => $city->country,
                    'geo' => [
                        'latitude' => $city->latitude,
                        'longitude' => $city->longitude,
                        'elevation' => $city->elevation
                    ]
                ],
                'cityKey' => $request->cityKey
            ]);
        }catch (\Exception $e){
            $this->write('ForecastController::getCitySlug()', $e->getCode(), $e->getMessage(), $request);
            return $this->apiResponse('3070', __('Greška prilikom obrade zahtjeva. Molimo kotantktirajte administratora!'));
        }
    }
}
