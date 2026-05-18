<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('urutan')->get();

        $query = Product::where('is_active', true)->with('category');

        if ($request->kategori) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->kategori));
        }

        if ($request->jenjang) {
            $query->where('jenjang', $request->jenjang);
        }

        if ($request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $products = $query->orderBy('urutan')->orderBy('judul')->paginate(12)->withQueryString();

        return view('katalog.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        abort_if(!$product->is_active, 404);

        $product->load('images');

        $related = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->limit(4)
            ->get();

        return view('katalog.show', compact('product', 'related'));
    }
}
