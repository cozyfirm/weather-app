<?php

namespace App\Traits\Http;


trait HttpTrait{

    /**
     * @return mixed
     * Get an IP ADDR from HTTP Request
     */
    protected function getIp(): mixed{
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
}
