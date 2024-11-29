<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cities extends Model{
    use HasFactory, SoftDeletes;

    protected $table = 'base__cities';
    protected $guarded = ['id'];


}
