<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'image_path', 'urutan'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getUrlAttribute(): string
    {
        if (file_exists(public_path('storage/' . $this->image_path))) {
            return asset('storage/' . $this->image_path);
        }
        if (file_exists(public_path('images/produk/' . $this->image_path))) {
            return asset('images/produk/' . $this->image_path);
        }
        return asset('images/produk/0-blank_photo.jpg');
    }
}
