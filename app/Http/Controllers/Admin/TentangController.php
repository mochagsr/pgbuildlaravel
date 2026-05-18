<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutImage;
use App\Models\AboutSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TentangController extends Controller
{
    public function edit()
    {
        $setting = AboutSetting::getSetting();
        $images  = AboutImage::orderBy('urutan')->get();
        return view('admin.tentang.edit', compact('setting', 'images'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'cover_image' => 'nullable|image|max:5120',
            'content'     => 'nullable|string',
        ]);

        $setting = AboutSetting::getSetting();

        if ($request->hasFile('cover_image')) {
            if ($setting->cover_image) {
                Storage::disk('public')->delete($setting->cover_image);
            }
            $setting->cover_image = $request->file('cover_image')->store('tentang', 'public');
        }

        if ($request->filled('content')) {
            $setting->content = $request->input('content');
        }

        $setting->save();

        return redirect()->route('admin.tentang.edit')->with('success', 'Halaman Tentang berhasil diperbarui.');
    }

    public function storeImage(Request $request)
    {
        $request->validate([
            'images'   => 'required|array|max:20',
            'images.*' => 'image|max:5120',
        ]);

        $urutan = AboutImage::max('urutan') + 1;

        foreach ($request->file('images') as $file) {
            $path = $file->store('tentang-gallery', 'public');
            if ($path) {
                AboutImage::create(['image_path' => $path, 'urutan' => $urutan++]);
            }
        }

        return redirect()->route('admin.tentang.edit')->with('success', 'Gambar galeri berhasil ditambahkan.');
    }

    public function destroyImage(AboutImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
        return redirect()->route('admin.tentang.edit')->with('success', 'Gambar berhasil dihapus.');
    }

    public function importStaticImages()
    {
        $files = ['t2','t3','t4','t5','t6','t7','t8','t9','t10','t11','t12','t13'];
        $urutan = AboutImage::max('urutan') + 1;

        foreach ($files as $f) {
            $src = public_path("images/tentang/{$f}.jpg");
            if (!file_exists($src)) continue;

            $dest = 'tentang-gallery/' . $f . '.jpg';
            // Salin file ke storage/app/public/tentang-gallery/
            if (!Storage::disk('public')->exists($dest)) {
                Storage::disk('public')->put($dest, file_get_contents($src));
            }
            // Simpan ke DB jika belum ada
            if (!AboutImage::where('image_path', $dest)->exists()) {
                AboutImage::create(['image_path' => $dest, 'urutan' => $urutan++]);
            }
        }

        return redirect()->route('admin.tentang.edit')->with('success', 'Gambar lama berhasil diimpor ke galeri.');
    }
}
