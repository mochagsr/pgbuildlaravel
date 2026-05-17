<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'judul', 'penulis', 'jenjang', 'kelas',
        'isbn', 'tahun', 'deskripsi', 'cover_image', 'is_active', 'urutan',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getCoverUrlAttribute(): string
    {
        if ($this->cover_image && file_exists(public_path('storage/' . $this->cover_image))) {
            return asset('storage/' . $this->cover_image);
        }
        return asset('images/produk/0-blank_photo.jpg');
    }
}
