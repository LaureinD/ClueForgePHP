<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = [
        'alt',
        'path',
        'type',
        'size',
        'is_primary'
    ];

    public function imageable() {
        return $this->morphTo();
    }

    protected static function booted() {
        static::deleting(function (self $image) {
            if ($image->filename && Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }
        });
    }
}
