<?php

namespace App\Models\Other;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static where(string $string, string $string1, int $int)
 * @method static create(array $all)
 * @method update (array $all)
 */
class FAQ extends Model{
    use HasFactory, SoftDeletes;

    protected $table = '__faq';
    protected $guarded = ['id'];

    /**
     *  Section relationships should be added later !!
     */
}
