<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Jenjang;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        if ($request->kategori) {
            $query->where('category_id', $request->kategori);
        }

        $products = $query->orderByDesc('id')->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.produk.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('urutan')->get();
        $jenjangs   = Jenjang::orderBy('urutan')->orderBy('nama')->get();
        return view('admin.produk.form', ['product' => new Product(), 'categories' => $categories, 'jenjangs' => $jenjangs]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'      => 'nullable|exists:categories,id',
            'judul'            => 'required|string|max:255',
            'penulis'          => 'nullable|string|max:255',
            'jenjang'          => 'nullable|string|max:50',
            'kelas'            => 'nullable|string|max:20',
            'isbn'             => 'nullable|string|max:50',
            'tahun'            => 'nullable|integer|min:2000|max:2100',
            'deskripsi'        => 'nullable|string',
            'is_active'        => 'nullable|boolean',
            'urutan'           => 'nullable|integer',
            'cover_image'      => 'nullable|image|max:5120',
            'gallery_images'   => 'nullable|array',
            'gallery_images.*' => 'image|max:5120',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['urutan']    = (int) ($data['urutan'] ?? 0);
        unset($data['gallery_images']);

        if ($data['urutan'] > 0) {
            Product::where('urutan', '>=', $data['urutan'])->increment('urutan');
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('produk', 'public');
        }

        $product = Product::create($data);

        // Simpan gambar galeri
        foreach ($request->file('gallery_images', []) as $idx => $file) {
            $product->images()->create([
                'image_path' => $file->store('produk-gallery', 'public'),
                'urutan'     => $idx + 1,
            ]);
        }

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $produk)
    {
        $categories = Category::orderBy('urutan')->get();
        $jenjangs   = Jenjang::orderBy('urutan')->orderBy('nama')->get();
        $produk->load('images');
        return view('admin.produk.form', ['product' => $produk, 'categories' => $categories, 'jenjangs' => $jenjangs]);
    }

    public function update(Request $request, Product $produk)
    {
        $data = $request->validate([
            'category_id'    => 'nullable|exists:categories,id',
            'judul'          => 'required|string|max:255',
            'penulis'        => 'nullable|string|max:255',
            'jenjang'        => 'nullable|string|max:50',
            'kelas'          => 'nullable|string|max:20',
            'isbn'           => 'nullable|string|max:50',
            'tahun'          => 'nullable|integer|min:2000|max:2100',
            'deskripsi'      => 'nullable|string',
            'is_active'      => 'nullable|boolean',
            'urutan'         => 'nullable|integer',
            'cover_image'    => 'nullable|image|max:5120',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['urutan']    = (int) ($data['urutan'] ?? 0);

        if ($data['urutan'] > 0 && $data['urutan'] !== $produk->urutan) {
            Product::where('id', '!=', $produk->id)
                ->where('urutan', '>=', $data['urutan'])
                ->increment('urutan');
        }

        // Ganti cover hanya jika ada file baru diupload; kosong = cover lama dipertahankan
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('produk', 'public');
        } else {
            unset($data['cover_image']);
        }

        $produk->update($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $produk)
    {
        $produk->delete();
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
