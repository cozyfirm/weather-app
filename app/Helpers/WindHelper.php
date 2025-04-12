<?php



class WindHelper{
    public static function windSpeed($speed): string{
        $speed = (int) $speed;

        if($speed <= 5) return __("Lagan povjetarac sa prosječnom brzinom od " . $speed . " km/h.");
        else if($speed <= 11) return __("Slab vjetar sa prosječnom brzinom od " . $speed . " km/h.");
        else if($speed <= 19) return __("Umjeren vjetar sa prosječnom brzinom od " . $speed . " km/h.");
        else if($speed <= 38) return __("Jak vjetar sa prosječnom brzinom od " . $speed . " km/h.");
        else if($speed <= 49) return __("Vrlo jak vjetar sa prosječnom brzinom od " . $speed . " km/h.");
        else if($speed <= 88) return __("Olujan vjetar sa prosječnom brzinom od " . $speed . " km/h.");
        else return __("Orkan sa prosječnom brzinom od " . $speed . " km/h.");
    }

    public static function windGustSpeed($speed): string{
        $speed = (int) $speed;

        if($speed < 10) return "";

        if($speed <= 50) return __("Očekuju se slabiji udari vjetra do " . $speed . " km/h.");
        else if($speed <= 70) return __("Očekuju se umjereni do jaki udari vjetra do " . $speed . " km/h.");
        else if($speed <= 90) return __("Očekuju se vrlo jaki udari vjetra do " . $speed . " km/h.");
        else if($speed <= 120) return __("Očekuju se olujni udari vjetra do " . $speed . " km/h.");
        else return __("Očekuju se orkanski udari vjetra do " . $speed . " km/h.");
    }
}
