<?php

namespace App\Models\Base\Forecast;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, $id)
 * @method static create(array $night)
 */
class FiveDaysInfo extends Model{
    use HasFactory;

    protected $table = 'base__five_days_forecast_info';
    protected $guarded = ['id'];
}
