<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @method static where(string $string, string $string1, $Key)
 * @method static orderBy(string $string, string $string1)
 */
class Cities extends Model{
    use HasFactory, SoftDeletes;

    protected $table = 'base__cities';
    protected $guarded = ['id'];


}
