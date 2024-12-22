<?php

use App\Models\Users\History\SearchHistory;
use Carbon\Carbon;

class temperatureHelper{
    public static mixed $_last_searched_city = null;

    public static function roundUp($temperature){
        $round = round($temperature);
        if($round == -0) $round = 0;
        return $round;
    }

    public static function lastSearchedCity(): mixed{
        if(self::$_last_searched_city){
            return self::$_last_searched_city;
        }else{
            self::$_last_searched_city = SearchHistory::where('ip_addr', '=', request()->ip())
                ->where('updated_at', '>=', Carbon::now()->subHours(8)->format('Y-m-d H:00:00'))
                ->orderBy('updated_at', 'DESC')
                ->first();
        }

        return self::$_last_searched_city;
    }
}
