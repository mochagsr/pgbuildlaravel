<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutImage extends Model
{
    protected $fillable = ['image_path', 'urutan'];

    public function getUrlAttribute(): string
    {
        if (file_exists(public_path('storage/' . $this->image_path))) {
            return asset('storage/' . $this->image_path);
        }
        return asset('images/tentang/head_tentang.jpg');
    }
}
