<?php

namespace App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Http\Request;

trait CommonTrait{
    protected array $_months = ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'];
    protected array $_full_months = ['Januar', 'Februar', 'Mart', 'April', 'Maj', 'Juni', 'Juli', 'August', 'Septembar', 'Oktobar', 'Novembar', 'Decembar'];
    protected array $_days = ['Ned', 'Pon', 'Uto', 'Sri', 'Čet', 'Pet', 'Sub'];
    protected array $_full_days = ['Nedjelja', 'Ponedjeljak', 'Utorak', 'Srijeda', 'Četvrtak', 'Petak', 'Subota'];
    protected static array $_time_arr = [];

    /**
     * Format array of times
     *
     * @return array
     */
    public static function formTimeArr(): array{
        for($i=0; $i<= 23; $i++){
            for($j=0; $j<60; $j+=15){
                $time = (($i < 10) ? ('0'.$i) : $i) . ':' . (($j < 10) ? ('0'.$j) : $j);
                self::$_time_arr[$time] = $time;
            }
        }

        return self::$_time_arr;
    }

    public function getPublicDate($dateTime): string{
        $carbonDT = Carbon::parse($dateTime);

        return $carbonDT->format('d') . ' ' . ($this->_months[(int)($carbonDT->format('m') - 1)]) . ', ' . ($this->_days[(int)($carbonDT->format('w'))]) . ' ' . $carbonDT->format('H:i');
    }
    public function getFullDateTime($dateTime): string{
        $carbonDT = Carbon::parse($dateTime);

        return ($this->_full_days[(int)($carbonDT->format('w'))]) . ', ' . $carbonDT->format('d') . ' ' . ($this->_months[(int)($carbonDT->format('m') - 1)]) . ' ' . $carbonDT->format('Y') . ' ' . $carbonDT->format('H:i');
    }
    public function dayAndTime($dateTime): string{
        $carbonDT = Carbon::parse($dateTime);

        return ($this->_days[(int)($carbonDT->format('w'))]) . ', ' . $carbonDT->format('H:i');
    }
    public function getPublicTime($dateTime): string{
        $carbonTime = Carbon::parse($dateTime);
        return $carbonTime->format('H:i');
    }
    public function getDay($date): string{
        return $this->_full_days[Carbon::parse($date)->format('w')];
    }
    public function getDayAndFullMonth($date): string{
        return Carbon::parse($date)->format('d') . ' ' .$this->_full_months[Carbon::parse($date)->format('m') - 1];
    }

    /**
     * Get user IP Address
     *
     * @return mixed
     */
    public static function getIp(): mixed{
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
}
