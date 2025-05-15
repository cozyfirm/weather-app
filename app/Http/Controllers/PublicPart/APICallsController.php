<?php

namespace App\Http\Controllers\PublicPart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class APICallsController extends Controller{
    public function twelveHourForecast(): void{
        try{
            Artisan::call('api:forecast:twelve-hours-forecast');
        }catch (\Exception $e){
            dd($e->getMessage());
        }
    }
    public function fiveDaysForecast(): void{
        try{
            Artisan::call('api:forecast:five-days-forecast');
        }catch (\Exception $e){
            dd($e->getMessage());
        }
    }
}
