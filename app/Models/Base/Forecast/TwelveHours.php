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

    public function getDateTime():string {
        return $this->getPublicDate($this->date_time);
    }
    public function getDayAndTime(): string{
        return $this->dayAndTime($this->date_time);
    }
    public function getTime(): string{
        return $this->getPublicTime($this->date_time);
    }
}
