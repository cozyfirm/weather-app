<?php

namespace App\Models\Base\Forecast;

use App\Traits\Common\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static where(string $string, string $string1, $key)
 */
class TwelveHours extends Model{
    use HasFactory, CommonTrait;

    protected $table = 'base__cities_forecast_th';
    protected $guarded = ['id'];
    protected $appends = ['icon_uri'];

    public function getDateTime():string {
        return $this->getPublicDate($this->date_time);
    }
    public function getDayAndTime(): string{
        return $this->dayAndTime($this->date_time);
    }
    public function getTime(): string{
        return $this->getPublicTime($this->date_time);
    }
    public function getIconUriAttribute(): string{
        return "https://vrijeme24.ba/files/images/" . $this->icon . ".png";
    }

    /**
     * Check for this one
     * @return string|null
     */
    public function effect(): ?string{
        if(!isset($this->icon)) return null;

        if($this->icon == 12 or $this->icon == 13 or $this->icon == 14 or $this->icon == 12 or $this->icon == 39 or $this->icon == 40) return "effect rain light-rain";
        else if($this->icon == 18) return "effect rain";
        else if($this->icon == 6) return "effect snow-effect";
        else return null;
    }
}
