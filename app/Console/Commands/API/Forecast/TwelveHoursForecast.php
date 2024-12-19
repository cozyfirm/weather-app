<?php

namespace App\Console\Commands\API\Forecast;

use App\Models\Base\Cities;
use App\Models\Base\Forecast\TwelveHours;
use App\Traits\API\ForecastTrait;
use App\Traits\Common\FileTrait;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TwelveHoursForecast extends Command{
    use ForecastTrait, FileTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:forecast:twelve-hours-forecast';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch 12 Hours forecast for all base cities';

    /**
     * Execute the console command.
     */

    public function handle(): void{
        $cities = Cities::get();

        foreach ($cities as $city){
            $uri = '12hour/' . $city->key;

            $forecast = $this->fetchForecast($uri, "hourly");
            foreach ($forecast as $sample){
                $dbSample = TwelveHours::where('city_key', '=', $city->key)
                    ->where('date_time', '=', Carbon::parse($sample->DateTime))
                    ->first();

                /* ToDo - Cannot fetch icons from AccuWeather.com */
                if(!$dbSample){
                    TwelveHours::create($this->prepareTwelveHoursForecastQuery($sample, $city->key));
                }else{
                    $dbSample->update($this->prepareTwelveHoursForecastQuery($sample));
                }
            }
        }
    }
}
