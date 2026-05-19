<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Product::count();
        $totalAktif = Product::where('is_active', true)->count();
        $totalKategori = Category::count();
        $produkTerbaru = Product::orderByDesc('id')->limit(5)->get();

        return view('admin.dashboard', compact('totalProduk', 'totalAktif', 'totalKategori', 'produkTerbaru'));
    }
}
