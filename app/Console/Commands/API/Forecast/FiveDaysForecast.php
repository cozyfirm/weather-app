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
        $cities = Cities::get();

        foreach ($cities as $city){
            $uri = '5day/' . $city->key;

            $forecast = $this->fetchForecast($uri, "daily");

            foreach ($forecast->DailyForecasts as $sample){
                $dbSample = FiveDays::where('city_key', '=', $city->key)
                    ->where('date', '=', Carbon::parse($sample->Date)->format('Y-m-d'))
                    ->first();

                $forecast = []; $day = []; $night = [];

                if(!$dbSample){
                    $this->prepareFiveDAysForecastQuery($sample, $forecast, $day, $night, $city->key);
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
}
