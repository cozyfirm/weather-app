<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Artisan::command('api:forecast:twelve-hours-forecast', function () {
    // You can call the handle method of your command class
    (new \App\Console\Commands\API\Forecast\TwelveHoursForecast())->handle();
})->purpose('Fetch 12 hours forecast for base cities');
