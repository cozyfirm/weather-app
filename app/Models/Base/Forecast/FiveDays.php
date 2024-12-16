<?php

namespace App\Models\Base\Forecast;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FiveDays extends Model{
    use HasFactory;

    protected $table = 'base__five_days_forecast';
    protected $guarded = ['id'];

    public function dayRel(): HasOne{
        return $this->HasOne(FiveDaysInfo::class, 'parent_id', 'id')->where('type', '=', 'day');
    }
    public function nightRel(): HasOne{
        return $this->HasOne(FiveDaysInfo::class, 'parent_id', 'id')->where('type', '=', 'night');
    }
}
