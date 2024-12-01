<?php

namespace App\Traits\API;

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
    public function searchBy(string $uri, $query, string $language = 'bs'): mixed{
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
}
