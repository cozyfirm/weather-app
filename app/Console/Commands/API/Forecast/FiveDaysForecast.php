<?php

namespace App\Console\Commands\API\Forecast;

use App\Models\Base\Cities;
use App\Models\Base\Forecast\FiveDays;
use App\Models\Base\Forecast\FiveDaysInfo;
use App\Traits\API\ForecastTrait;
use App\Traits\Common\FileTrait;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FiveDaysForecast extends Command{
    use ForecastTrait, FileTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:forecast:five-days-forecast';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch 5 days forecast for all base cities';

    /**
     * Execute the console command.
     */
    public function handle(){
        $cities = Cities::where('base', '=', 1)->get();

        foreach ($cities as $city){
            $this->saveFiveDaysForecast($city->key);
        }
    }
}
