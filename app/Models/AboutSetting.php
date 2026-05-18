<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSetting extends Model
{
    protected $fillable = ['cover_image', 'content'];

    public function getCoverUrlAttribute(): string
    {
        if ($this->cover_image) {
            if (file_exists(public_path('storage/' . $this->cover_image))) {
                return asset('storage/' . $this->cover_image);
            }
            if (file_exists(public_path('images/tentang/' . $this->cover_image))) {
                return asset('images/tentang/' . $this->cover_image);
            }
        }
        return asset('images/tentang/head_tentang.jpg');
    }

    public static function getSetting(): self
    {
        return self::firstOrCreate([]);
    }
}
