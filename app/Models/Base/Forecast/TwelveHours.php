<?php

namespace App\Models\Base\Forecast;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class TwelveHours extends Model{
    use HasFactory;

    protected $table = 'base__cities_forecast_th';
    protected $guarded = ['id'];


}