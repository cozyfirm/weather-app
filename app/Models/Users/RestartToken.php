<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestartToken extends Model{
    use HasFactory;

    protected $table = 'password_reset_tokens';
    protected $guarded = ['id'];

    /* Override updated_at => Set to NULL */
    public function setUpdatedAtAttribute(){}
}

