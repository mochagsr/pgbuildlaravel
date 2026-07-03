<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jenjang;
use App\Models\Product;
use Illuminate\Http\Request;

class JenjangController extends Controller
{
    public function index()
    {
        $jenjangs = Jenjang::orderBy('urutan')->orderBy('nama')->get();

        // Jumlah produk per jenjang (kolom products.jenjang berupa teks nama)
        $counts = Product::selectRaw('jenjang, COUNT(*) as total')
            ->groupBy('jenjang')
            ->pluck('total', 'jenjang');

        return view('admin.jenjang.index', compact('jenjangs', 'counts'));
    }

    public function create()
    {
        return view('admin.jenjang.form', ['jenjang' => new Jenjang()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'   => 'required|string|max:100|unique:jenjangs,nama',
            'urutan' => 'nullable|integer',
        ]);

        $data['urutan'] = (int) ($data['urutan'] ?? 0);

        if ($data['urutan'] > 0) {
            Jenjang::where('urutan', '>=', $data['urutan'])->increment('urutan');
        }

        Jenjang::create($data);

        return redirect()->route('admin.jenjang.index')->with('success', 'Jenjang berhasil ditambahkan.');
    }

    public function edit(Jenjang $jenjang)
    {
        return view('admin.jenjang.form', ['jenjang' => $jenjang]);
    }

    public function update(Request $request, Jenjang $jenjang)
    {
        $data = $request->validate([
            'nama'   => 'required|string|max:100|unique:jenjangs,nama,' . $jenjang->id,
            'urutan' => 'nullable|integer',
        ]);

        $namaLama = $jenjang->nama;
        $data['urutan'] = (int) ($data['urutan'] ?? 0);

        if ($data['urutan'] > 0 && $data['urutan'] !== $jenjang->urutan) {
            Jenjang::where('id', '!=', $jenjang->id)
                ->where('urutan', '>=', $data['urutan'])
                ->increment('urutan');
        }

        $jenjang->update($data);

        // Jaga konsistensi: produk yang memakai jenjang ini ikut diperbarui namanya
        if ($namaLama !== $data['nama']) {
            Product::where('jenjang', $namaLama)->update(['jenjang' => $data['nama']]);
        }

        return redirect()->route('admin.jenjang.index')->with('success', 'Jenjang berhasil diperbarui.');
    }

    public function destroy(Jenjang $jenjang)
    {
        $terpakai = Product::where('jenjang', $jenjang->nama)->count();
        if ($terpakai > 0) {
            return redirect()->route('admin.jenjang.index')
                ->with('error', "Jenjang \"{$jenjang->nama}\" masih dipakai {$terpakai} produk, tidak bisa dihapus.");
        }

        $jenjang->delete();

        return redirect()->route('admin.jenjang.index')->with('success', 'Jenjang berhasil dihapus.');
    }
}
