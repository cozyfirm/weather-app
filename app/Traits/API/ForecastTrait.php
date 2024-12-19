<?php

namespace App\Traits\API;

use App\Models\Base\Forecast\FiveDays;
use App\Models\Base\Forecast\FiveDaysInfo;
use App\Models\Base\Forecast\TwelveHours;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

trait ForecastTrait{
    protected string $_hourly_forecast_uri_path = 'forecasts/v1/hourly';
    protected string $_daily_forecast_uri_path = 'forecasts/v1/daily';

    public function constructUri($uri, $apiType): string{
        if($apiType == "hourly") return env('ACCU_WEATHER_BASE_URI') . $this->_hourly_forecast_uri_path . '/' . $uri;
        else if($apiType == "daily") return env('ACCU_WEATHER_BASE_URI') . $this->_daily_forecast_uri_path . '/' . $uri;
    }
    public function fetchForecast($uri, string $apiType, string $language = "bs", string $details = "true", string $metric = "true"): mixed{
        $client = new Client();

        try {
            $response = $client->request('GET', $this->constructUri($uri, $apiType), [
                'query' => [
                    'apikey' => env('ACCU_WEATHER_API'),
                    'language' => $language,
                    'details' => $details,
                    'metric' => $metric
                ]
            ]);
        } catch (GuzzleException $e) {
            return false;
        }
        if($response->getStatusCode() == 200) return json_decode($response->getBody());
        else return false;
    }

    public function prepareTwelveHoursForecastQuery($sample, $key = null): array{
        $queryArr = [
            'date' => Carbon::parse($sample->DateTime)->format('Y-m-d'),
            'time' => Carbon::parse($sample->DateTime)->format('H:i:s'),
            'date_time' => Carbon::parse($sample->DateTime),

            'metric' => true,
            'icon' => $sample->WeatherIcon ?? '',
            'phase' => $sample->IconPhrase ?? '',

            'has_precipitation' => $sample->HasPrecipitation ?? '',
            'precipitation_type' => $sample->PrecipitationType ?? '',
            'precipitation_intensity' => $sample->PrecipitationIntensity ?? '',

            'is_daylight' => $sample->IsDaylight ?? '',

            'temperature' => $sample->Temperature->Value ?? '',
            'temperature_rf' => $sample->RealFeelTemperature->Value ?? '',
            'temperature_desc' => $sample->RealFeelTemperature->Phrase ?? '',
            'temperature_s_rf' => $sample->RealFeelTemperatureShade->Value ?? '',
            'temperature_s_desc' => $sample->RealFeelTemperatureShade->Phrase ?? '',

            'dev_point' => $sample->DewPoint->Value ?? '',

            'wind_speed' => $sample->Wind->Speed->Value ?? '',
            'wind_gust_speed' => $sample->WindGust->Speed->Value ?? '',
            'wind_direction_deg' => $sample->Wind->Direction->Degrees ?? '',
            'wind_direction_l' => $sample->Wind->Direction->Localized ?? '',
            'wind_direction_e' => $sample->Wind->Direction->English ?? '',

            'rel_humidity' => $sample->RelativeHumidity ?? '',
            'rel_indoor_humidity' => $sample->IndoorRelativeHumidity ?? '',
            'visibility' => $sample->Visibility->Value ?? '',
            'ceiling' => $sample->Ceiling->Value ?? '',
            'cloud_cover' => $sample->CloudCover ?? '',

            'uv_index' => $sample->UVIndex ?? '',
            'uv_index_text' => $sample->UVIndexText ?? '',

            'precipitation_probability' => $sample->PrecipitationProbability ?? '',
            'thunderstorm_probability' => $sample->ThunderstormProbability ?? '',
            'rain_probability' => $sample->RainProbability ?? '',
            'snow_probability' => $sample->SnowProbability ?? '',
            'ice_probability' => $sample->IceProbability ?? '',

            'total_liquid' => $sample->TotalLiquid->Value ?? '',
            'total_rain' => $sample->Rain->Value ?? '',
            'total_snow' => $sample->Snow->Value ?? '',
            'total_ice' => $sample->Ice->Value ?? '',

            'solar_irradiance' => $sample->SolarIrradiance->Value ?? ''
        ];
        if(isset($key)) $queryArr['city_key'] = $key;

        return $queryArr;
    }

    public function saveTwelveHoursForecast($cityKey): void{
        $uri = '12hour/' . $cityKey;

        $forecast = $this->fetchForecast($uri, "hourly");
        foreach ($forecast as $sample){
            $dbSample = TwelveHours::where('city_key', '=', $cityKey)
                ->where('date_time', '=', Carbon::parse($sample->DateTime))
                ->first();

            /* ToDo - Cannot fetch icons from AccuWeather.com */
            if(!$dbSample){
                TwelveHours::create($this->prepareTwelveHoursForecastQuery($sample, $cityKey));
            }else{
                $dbSample->update($this->prepareTwelveHoursForecastQuery($sample));
            }
        }
    }

    /**
     *  Five days forecast
     */
    public function dayAndNightInfo($sample, $type, &$object): void{
        $object = [
            'type' => strtolower($type),

            'icon' => $sample->$type->Icon ?? '',
            'phrase' => $sample->$type->IconPhrase ?? '',
            'short_phrase' => $sample->$type->ShortPhrase ?? '',
            'long_phrase' => $sample->$type->LongPhrase ?? '',

            'has_precipitation' => $sample->$type->HasPrecipitation ?? '',
            'precipitation_type' => $sample->$type->PrecipitationType ?? '',
            'precipitation_intensity' => $sample->$type->PrecipitationIntensity ?? '',

            'precipitation_probability' => $sample->$type->PrecipitationProbability ?? '',
            'thunderstorm_probability' => $sample->$type->ThunderstormProbability ?? '',
            'rain_probability' => $sample->$type->RainProbability ?? '',
            'snow_probability' => $sample->$type->SnowProbability ?? '',
            'ice_probability' => $sample->$type->IceProbability ?? '',

            'wind_speed' => $sample->$type->Wind->Speed->Value ?? '',
            'wind_gust_speed' => $sample->$type->WindGust->Speed->Value ?? '',
            'wind_direction_deg' => $sample->$type->Wind->Direction->Degrees ?? '',
            'wind_direction_l' => $sample->$type->Wind->Direction->Localized ?? '',
            'wind_direction_e' => $sample->$type->Wind->Direction->English ?? '',

            'total_liquid' => $sample->$type->TotalLiquid->Value ?? '',
            'total_rain' => $sample->$type->Rain->Value ?? '',
            'total_snow' => $sample->$type->Snow->Value ?? '',
            'total_ice' => $sample->$type->Ice->Value ?? '',

            'hours_of_precipitation' => $sample->$type->HoursOfPrecipitation ?? '',
            'hours_of__rain' => $sample->$type->HoursOfRain ?? '',
            'hours_of__snow' => $sample->$type->HoursOfSnow ?? '',
            'hours_of__ice' => $sample->$type->HoursOfIce ?? '',

            'cloud_cover' => $sample->$type->CloudCover ?? '',

            'rel_humidity_min' => $sample->$type->RelativeHumidity->Minimum ?? '',
            'rel_humidity_max' => $sample->$type->RelativeHumidity->Maximum ?? '',
            'rel_humidity_avg' => $sample->$type->RelativeHumidity->Average ?? '',
        ];
    }
    public function prepareFiveDAysForecastQuery($sample, &$forecast, &$day, &$night, $key = null): void{

        $forecast = [
            'date' => Carbon::parse($sample->Date)->format('Y-m-d'),
            'metric' => true,

            'sunrise' => Carbon::parse($sample->Sun->Rise)->format('Y-m-d H:i:s'),
            'sunset' => Carbon::parse($sample->Sun->Set)->format('Y-m-d H:i:s'),
            'moonrise' => Carbon::parse($sample->Moon->Rise)->format('Y-m-d H:i:s'),
            'moonset' => Carbon::parse($sample->Moon->Set)->format('Y-m-d H:i:s'),

            'min_temp' => $sample->Temperature->Minimum->Value ?? '',
            'min_temp_rf' => $sample->RealFeelTemperature->Minimum->Value ?? '',
            'min_temp_desc' => $sample->RealFeelTemperature->Minimum->Phrase ?? '',

            'max_temp' => $sample->Temperature->Maximum->Value ?? '',
            'max_temp_rf' => $sample->RealFeelTemperature->Maximum->Value ?? '',
            'max_temp_desc' => $sample->RealFeelTemperature->Maximum->Phrase ?? '',

            'hours_of_sun' => $sample->HoursOfSun ?? '',

            'uv_index' => $sample->HoursOfSun ?? '',
            'uv_index_desc' => $sample->RealFeelTemperature->Maximum->Phrase ?? '',
        ];

        /**
         *  Get UV Index from array
         */
        try{
            foreach ($sample->AirAndPollen as $extra){
                if($extra->Name == 'UVIndex'){
                    $forecast['uv_index'] = $extra->Value;
                    $forecast['uv_index_desc'] = $extra->Category;
                }
            }
        }catch (\Exception $e){}
        if(isset($key)) $forecast['city_key'] = $key;

        /**
         *  Day and night info
         */
        $this->dayAndNightInfo($sample, "Day", $day);
        $this->dayAndNightInfo($sample, "Night", $night);
    }
    public function saveFiveDaysForecast($cityKey): void{
        $uri = '5day/' . $cityKey;

        $forecast = $this->fetchForecast($uri, "daily");

        foreach ($forecast->DailyForecasts as $sample){
            $dbSample = FiveDays::where('city_key', '=', $cityKey)
                ->where('date', '=', Carbon::parse($sample->Date)->format('Y-m-d'))
                ->first();

            $forecast = []; $day = []; $night = [];

            if(!$dbSample){
                $this->prepareFiveDAysForecastQuery($sample, $forecast, $day, $night, $cityKey);
                $dbSample = FiveDays::create($forecast);
            }else{
                $this->prepareFiveDAysForecastQuery($sample, $forecast, $day, $night);
                $dbSample->update($forecast);
            }

            /**
             *  Delete night and day info
             */
            FiveDaysInfo::where('parent_id', '=', $dbSample->id)->delete();

            $day['parent_id'] = $dbSample->id;
            $night['parent_id'] = $dbSample->id;

            FiveDaysInfo::create($day);
            FiveDaysInfo::create($night);
        }
    }
}
