<?php

namespace App\Traits\API;

use App\Models\Base\Cities;
use App\Traits\Common\CommonTrait;
use App\Traits\Mqtt\MqttTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;

trait LocationsTrait{
    use CommonTrait, MqttTrait;
    protected string $_uri_path = 'locations/v1/';

    /* Construct uri from env params */
    public function constructUri($uri): string{
        return env('ACCU_WEATHER_BASE_URI') . $this->_uri_path . $uri;
    }
    public function constructQuery($queryString, $language, $details = false): array{
        $query = [];
        $query['apikey'] = env('ACCU_WEATHER_API');
        $query['language'] = $language;
        if(isset($queryString)) $query['q'] = $queryString;

        return $query;
    }

    /**
     * @param string $uri
     * @param string $search
     * @param string $language
     * @return false|mixed
     */
    public function searchBy(string $uri, $query, string $language = 'hr'): mixed{
        $client = new Client();

        try {
            $response = $client->request('GET', $this->constructUri($uri) , [
                'query' => $this->constructQuery($query, $language)
            ]);
        } catch (GuzzleException $e) {
            return false;
        }

        if($response->getStatusCode() == 200) return json_decode($response->getBody());
        else return false;
    }

    public function createCityObject($cityKey, $city, $base = false){
        return Cities::create([
            'key' => $cityKey,
            'name' => $city->LocalizedName ?? '',
            'name_eng' => $city->EnglishName ?? '',
            'region_id' => $city->Region->ID ?? '',
            'region' => $city->Region->LocalizedName ?? '',
            'region_eng' => $city->Region->EnglishName ?? '',
            'country_id' => $city->Country->ID ?? '',
            'country' => $city->Country->LocalizedName ?? '',
            'country_eng' => $city->Country->EnglishName ?? '',
            'area_id' => $city->AdministrativeArea->ID ?? '',
            'area' => $city->AdministrativeArea->LocalizedName ?? '',
            'area_eng' => $city->AdministrativeArea->EnglishName ?? '',
            'latitude' => $city->GeoPosition->Latitude ?? '0.000',
            'longitude' => $city->GeoPosition->Longitude ?? '0.000',
            'elevation' => $city->GeoPosition->Elevation->Metric->Value ?? '0.0',
            'base' => $base
        ]);
    }
}
