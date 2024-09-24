<?php

namespace App\Models\Other;

use App\Models\Core\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Page extends Model{
    use HasFactory;

    protected $table = '__single_pages';
    protected $guarded = ['id'];

    public function fileRel(): HasOne{
        return $this->hasOne(File::class, 'id', 'image_id');
    }
}
