<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $file
 * @property string $name
 * @property string $ext
 * @property string $type
 * @property string $path
 */
class File extends Model{
    use HasFactory;

    protected $table = '__files';
    protected $guarded = ['id'];

    public function getFile(): string {
        return "/{$this->path}/{$this->name}";
    }
}
