<?php

use App\Models\Users\History\SearchHistory;
use App\Traits\Common\CommonTrait;
use Carbon\Carbon;

class HistoryHelper{
    use CommonTrait;
    protected static array $_helper_months = ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'];

    public static function lastSearch(): mixed{
        $object = SearchHistory::where('ip_addr', '=', self::getIp())->orderBy('updated_at', 'DESC')->first();

        if($object){
            return Carbon::parse($object->updated_at)->format('d') . ' ' . (self::$_helper_months[(int)(Carbon::parse($object->updated_at)->format('m') - 1)]) . ' ' . Carbon::parse($object->updated_at)->format('H:i');
        }
    }
}
