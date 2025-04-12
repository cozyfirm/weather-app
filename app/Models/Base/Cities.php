<?php

namespace App\Models\Base;

use App\Models\Base\Forecast\FiveDays;
use App\Models\Base\Forecast\TwelveHours;
use App\Models\Core\Keyword;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @method static where(string $string, string $string1, $Key)
 * @method static orderBy(string $string, string $string1)
 * @method static get()
 * @method static inRandomOrder()
 */
class Cities extends Model{
    use HasFactory, SoftDeletes;

    protected $table = 'base__cities';
    protected $guarded = ['id'];

    public function getName(){
        if(!isset($this->name) or !isset($this->name_eng)) return __("Nije poznato");
        if($this->name == "") return $this->name_eng;
        else return $this->name;
    }
    public function baseCityRel(): HasOne{
        return $this->hasOne(Keyword::class, 'value', 'base')->where('type', '=', 'yes_no');
    }
    public function twelveHoursRel(): HasMany{
        return $this->hasMany(TwelveHours::class, 'city_key', 'key')->where('date_time', '>=', Carbon::now()->format('Y-m-d H:00:00'));
    }
    public function twelveHoursCurrentRel(): HasOne{
        return $this->hasOne(TwelveHours::class, 'city_key', 'key')->where('date_time', '>=', Carbon::now()->format('Y-m-d H:00:00'));
    }

    public function fiveDaysRel(): HasMany{
        return $this->hasMany(FiveDays::class, 'city_key', 'key')->where('date', '>=', Carbon::now()->format('Y-m-d'))->orderBy('id', 'ASC');
    }

    /**
     *  Helper methods
     */
    public function currentTemperature(): string{
        return ($this->twelveHoursCurrentRel->temperature ?? '0') . ' °C';
    }
    public function currentHumidity(): string{
        return ($this->twelveHoursCurrentRel->rel_humidity ?? '0') . ' %';
    }
    public function currentWind(): string{
        return ($this->twelveHoursCurrentRel->wind_speed ?? '0') . ' km/h';
    }
}
