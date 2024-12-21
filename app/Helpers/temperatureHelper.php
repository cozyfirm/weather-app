<?php

class temperatureHelper{
    public static function roundUp($temperature){
        $round = round($temperature);
        if($round == -0) $round = 0;
        return $round;
    }
}
