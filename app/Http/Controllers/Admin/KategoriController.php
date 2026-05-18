<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('urutan')->get();
        return view('admin.kategori.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.kategori.form', ['category' => new Category()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'urutan' => 'nullable|integer',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['urutan'] = (int) ($data['urutan'] ?? 0);

        if ($data['urutan'] > 0) {
            Category::where('urutan', '>=', $data['urutan'])->increment('urutan');
        }

        Category::create($data);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $kategori)
    {
        return view('admin.kategori.form', ['category' => $kategori]);
    }

    public function update(Request $request, Category $kategori)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'urutan' => 'nullable|integer',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['urutan'] = (int) ($data['urutan'] ?? 0);

        if ($data['urutan'] > 0 && $data['urutan'] !== $kategori->urutan) {
            Category::where('id', '!=', $kategori->id)
                ->where('urutan', '>=', $data['urutan'])
                ->increment('urutan');
        }

        $kategori->update($data);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $kategori)
    {
        $kategori->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
