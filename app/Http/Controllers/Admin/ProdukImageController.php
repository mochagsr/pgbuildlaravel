<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukImageController extends Controller
{
    public function store(Request $request, Product $produk)
    {
        \Log::info('Gallery upload attempt', [
            'produk_id'   => $produk->id,
            'has_files'   => $request->hasFile('images'),
            'files_count' => count($request->file('images', [])),
            'all_keys'    => array_keys($request->allFiles()),
        ]);

        $validated = $request->validate([
            'images'   => 'required|array|max:10',
            'images.*' => 'image|max:5120',
        ]);

        $urutan = $produk->images()->max('urutan') + 1;

        foreach ($request->file('images') as $file) {
            $path = $file->store('produk-gallery', 'public');
            \Log::info('File stored', ['path' => $path, 'original' => $file->getClientOriginalName()]);
            if ($path) {
                $produk->images()->create(['image_path' => $path, 'urutan' => $urutan++]);
            }
        }

        return redirect()->route('admin.produk.edit', $produk)->with('success', 'Gambar berhasil ditambahkan.');
    }

    public function destroy(ProductImage $image)
    {
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }
        $image->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }
}
