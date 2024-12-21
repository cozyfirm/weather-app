<?php

namespace App\Models\Base\Forecast;

use App\Traits\Common\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static where(string $string, string $string1, $key)
 * @method static create(array $forecast)
 */
class FiveDays extends Model{
    use HasFactory, CommonTrait;

    protected $table = 'base__five_days_forecast';
    protected $guarded = ['id'];

    public function dayRel(): HasOne{
        return $this->HasOne(FiveDaysInfo::class, 'parent_id', 'id')->where('type', '=', 'day');
    }
    public function nightRel(): HasOne{
        return $this->HasOne(FiveDaysInfo::class, 'parent_id', 'id')->where('type', '=', 'night');
    }
    public function weekDay(): string{
        return $this->getDay($this->date);
    }
    public function dateAndMonth(): string{
        return $this->getDayAndFullMonth($this->date);
    }
    public function getSunrise(): string{
        return $this->getPublicTime($this->sunrise);
    }
    public function getSunset(): string{
        return $this->getPublicTime($this->sunset);
    }
}
