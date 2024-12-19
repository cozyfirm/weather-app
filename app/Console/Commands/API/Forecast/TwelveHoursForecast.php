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
        $cities = Cities::where('base', '=', 1)->get();

        foreach ($cities as $city){
            $this->saveTwelveHoursForecast($city->key);
        }
    }
}
