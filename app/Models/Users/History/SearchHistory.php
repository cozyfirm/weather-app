<?php

namespace App\Models\Users\History;

use App\Models\Base\Cities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $array)
 * @method static where(string $string, string $string1, $cityKey)
 */
class SearchHistory extends Model{
    use HasFactory;

    protected $table = 'search__history';
    protected $guarded = ['id'];

    public function cityRel(): HasOne{
        return $this->hasOne(Cities::class, 'key', 'city_key');
    }
}
