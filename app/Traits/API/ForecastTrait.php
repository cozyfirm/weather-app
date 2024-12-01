<?php

namespace App\Traits\API;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

trait ForecastTrait{
    protected string $_forecast_uri_path = 'forecasts/v1/hourly';
    public function constructUri($uri): string{
        return env('ACCU_WEATHER_BASE_URI') . $this->_forecast_uri_path . '/' . $uri;
    }
    public function fetchTwelveHoursForecast($uri, string $language = "bs", string $details = "true", string $metric = "true"): mixed{
        $client = new Client();

        try {
            $response = $client->request('GET', $this->constructUri($uri), [
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
}
