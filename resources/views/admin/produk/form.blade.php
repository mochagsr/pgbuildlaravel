@extends('layouts.admin')

@section('title', $product->exists ? 'Edit Produk' : 'Tambah Produk')
@section('page-title', $product->exists ? 'Edit Produk' : 'Tambah Produk Baru')
@section('page-subtitle', $product->exists ? 'Perbarui data produk' : 'Isi data buku baru untuk katalog')

@push('scripts')
<style>
.produk-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.25rem;
    align-items: start;
}
@media (min-width: 1100px) {
    .produk-grid { grid-template-columns: 1fr 1fr; }
}
.form-input {
    width: 100%;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 0.45rem 0.75rem;
    font-size: 0.8125rem;
    outline: none;
    box-sizing: border-box;
}
.form-input:focus { box-shadow: 0 0 0 2px #93c5fd; border-color: #93c5fd; }
.form-label { display: block; font-size: 0.75rem; font-weight: 600; color: #374151; margin-bottom: 0.35rem; }
.card { background: #fff; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,.08); padding: 1rem 1.125rem; }
.card-title { font-size: 0.7rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: .06em; border-bottom: 1px solid #f3f4f6; padding-bottom: 0.5rem; margin-bottom: 0.875rem; }
.field { margin-bottom: 0.75rem; }
.field:last-child { margin-bottom: 0; }
.grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }
</style>
@endpush

@section('content')

{{-- Tampil semua error validasi --}}
@if($errors->any())
<div style="background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;padding:.75rem 1rem;border-radius:.5rem;margin-bottom:1rem;font-size:.8125rem;">
    <strong>Ada kesalahan:</strong>
    <ul style="margin:.25rem 0 0 1rem;padding:0;">
        @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
    </ul>
</div>
@endif

{{-- Form utama — ditempatkan di sini tapi inputnya bisa di mana saja via form="main-form" --}}
<form id="main-form"
      method="POST"
      action="{{ $product->exists ? route('admin.produk.update', $product) : route('admin.produk.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if($product->exists) @method('PUT') @endif
</form>

<div class="produk-grid">

    {{-- Kolom Kiri: Informasi Buku --}}
    <div class="card">
        <div class="card-title">Informasi Buku</div>

        <div class="field">
            <label class="form-label">Judul Buku <span style="color:#ef4444">*</span></label>
            <input form="main-form" type="text" name="judul" value="{{ old('judul', $product->judul) }}" required
                   class="form-input @error('judul') border-red-400 @enderror"
                   placeholder="Masukkan judul buku">
            @error('judul')<p style="color:#ef4444;font-size:.7rem;margin-top:.25rem">{{ $message }}</p>@enderror
        </div>

        <div class="field">
            <label class="form-label">Penulis</label>
            <input form="main-form" type="text" name="penulis" value="{{ old('penulis', $product->penulis) }}"
                   class="form-input" placeholder="Nama penulis">
        </div>

        <div class="field grid-2">
            <div>
                <label class="form-label">Kategori</label>
                <select form="main-form" name="category_id" class="form-input">
                    <option value="">-- Tanpa Kategori --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Jenjang</label>
                <select form="main-form" name="jenjang" class="form-input">
                    <option value="">-- Pilih --</option>
                    @foreach($jenjangs as $j)
                    <option value="{{ $j->nama }}" {{ old('jenjang', $product->jenjang) === $j->nama ? 'selected' : '' }}>{{ $j->nama }}</option>
                    @endforeach
                    {{-- Jaga nilai lama yang belum terdaftar di menu Kelola Jenjang agar tetap tampil --}}
                    @if($product->jenjang && !$jenjangs->contains('nama', $product->jenjang))
                    <option value="{{ $product->jenjang }}" selected>{{ $product->jenjang }} (belum terdaftar)</option>
                    @endif
                </select>
                <p style="font-size:.7rem;color:#9ca3af;margin-top:.25rem">Pilihan diatur di menu <strong>Kelola Jenjang</strong>.</p>
            </div>
        </div>

        <div class="field grid-2">
            <div>
                <label class="form-label">Kelas</label>
                <input form="main-form" type="text" name="kelas" value="{{ old('kelas', $product->kelas) }}"
                       class="form-input" placeholder="Contoh: 7 atau 1-3">
            </div>
            <div>
                <label class="form-label">Tahun Terbit</label>
                <input form="main-form" type="number" name="tahun" value="{{ old('tahun', $product->tahun) }}"
                       min="2000" max="2100" class="form-input" placeholder="{{ date('Y') }}">
            </div>
        </div>

        <div class="field">
            <label class="form-label">ISBN</label>
            <input form="main-form" type="text" name="isbn" value="{{ old('isbn', $product->isbn) }}"
                   class="form-input" placeholder="Nomor ISBN buku">
        </div>

        <div class="field">
            <label class="form-label">Deskripsi</label>
            <textarea form="main-form" name="deskripsi" rows="6" class="form-input"
                      style="resize:vertical" placeholder="Deskripsi singkat buku...">{{ old('deskripsi', $product->deskripsi) }}</textarea>
        </div>
    </div>

    {{-- Kolom Kanan --}}
    <div style="display:flex;flex-direction:column;gap:1rem;">

        {{-- Cover Buku --}}
        <div class="card">
            <div class="card-title">Cover Buku</div>
            <div style="display:flex;gap:0.75rem;align-items:flex-start;">
                <div id="preview-wrap" style="{{ $product->exists ? '' : 'display:none;' }}flex-shrink:0;">
                    <img id="preview-img" src="{{ $product->exists ? $product->cover_url : '' }}"
                         alt="Preview" style="width:60px;height:80px;object-fit:cover;border-radius:0.5rem;box-shadow:0 1px 3px rgba(0,0,0,.15);">
                </div>
                <div style="flex:1;min-width:0;">
                    <label class="form-label">
                        Upload Cover
                        @if($product->exists)<span style="font-weight:400;color:#9ca3af;font-size:.7rem"> (kosong = tidak diubah)</span>@endif
                    </label>
                    <input form="main-form" type="file" name="cover_image" id="cover_image" accept="image/*"
                           class="form-input" onchange="previewImage(this)">
                    <p style="font-size:.7rem;color:#9ca3af;margin-top:.25rem">JPG, PNG, WebP. Maks 5MB.</p>
                    @error('cover_image')<p style="color:#ef4444;font-size:.7rem;margin-top:.25rem">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Pengaturan --}}
        <div class="card">
            <div class="card-title">Pengaturan</div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input form="main-form" type="checkbox" name="is_active" value="1" class="sr-only peer"
                       {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-900"></div>
                <span style="margin-left:.5rem;font-size:.8125rem;font-weight:600;color:#374151;">Aktif</span>
            </label>
            <p style="font-size:.7rem;color:#9ca3af;margin-top:.5rem">Produk baru otomatis tampil paling atas di katalog.</p>
        </div>

        {{-- Galeri Gambar --}}
        <div class="card">
            <div class="card-title">
                Galeri <span style="font-weight:400;font-size:.65rem;color:#9ca3af;text-transform:none;letter-spacing:0;">(carousel di halaman detail)</span>
            </div>

            @if($product->exists)
                @if($product->images->count())
                <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:0.4rem;margin-bottom:0.75rem;">
                    @foreach($product->images as $img)
                    <div style="position:relative;" class="group">
                        <img src="{{ $img->url }}" style="width:100%;aspect-ratio:1;object-fit:cover;border-radius:0.4rem;box-shadow:0 1px 2px rgba(0,0,0,.1);">
                        {{-- Form hapus gambar — form tersendiri, tidak nested --}}
                        <form method="POST" action="{{ route('admin.produk.images.destroy', $img) }}"
                              onsubmit="return confirm('Hapus gambar ini?')"
                              style="position:absolute;top:3px;right:3px;" class="opacity-0 group-hover:opacity-100 transition">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    style="background:#ef4444;color:#fff;border:none;border-radius:50%;width:20px;height:20px;display:flex;align-items:center;justify-content:center;font-size:.6rem;cursor:pointer;">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
                @else
                <p style="font-size:.75rem;color:#9ca3af;margin-bottom:.75rem;">Belum ada gambar galeri.</p>
                @endif

                {{-- Upload galeri — form tersendiri (tidak nested), submit normal.
                     Action pakai URL relatif (absolute:false) agar aman dari mixed content HTTP/HTTPS. --}}
                <form method="POST" action="{{ route('admin.produk.images.store', $product, false) }}"
                      enctype="multipart/form-data">
                    @csrf
                    <label class="form-label">Tambah Gambar</label>
                    <div style="display:flex;gap:0.5rem;align-items:center;">
                        <input type="file" name="images[]" multiple accept="image/*" required
                               class="form-input" style="flex:1;min-width:0;">
                        <button type="submit"
                                style="flex-shrink:0;background:#1e3a5f;color:#fff;border:none;padding:.45rem .85rem;border-radius:.5rem;font-size:.8rem;cursor:pointer;">
                            <i class="fas fa-upload"></i> Upload
                        </button>
                    </div>
                    <p style="font-size:.7rem;color:#9ca3af;margin-top:.25rem">Bisa pilih lebih dari 1. Maks 5MB per gambar.</p>
                </form>

            @else
                {{-- Saat buat baru: galeri masuk form utama --}}
                <div>
                    <label class="form-label">Upload Gambar Galeri</label>
                    <input form="main-form" type="file" name="gallery_images[]" multiple accept="image/*"
                           class="form-input" onchange="previewGallery(this)">
                    <p style="font-size:.7rem;color:#9ca3af;margin-top:.25rem">Bisa pilih lebih dari 1. Maks 5MB.</p>
                    <div id="gallery-preview" style="display:flex;flex-wrap:wrap;gap:.5rem;margin-top:.5rem;"></div>
                </div>
            @endif
        </div>

    </div>{{-- /col-right --}}
</div>{{-- /produk-grid --}}

{{-- Tombol submit — merujuk ke form utama via form="main-form" --}}
<div style="display:flex;gap:.75rem;margin-top:1.25rem;">
    <button type="submit" form="main-form"
            class="inline-flex items-center gap-2 bg-blue-900 hover:bg-blue-800 text-white font-semibold px-5 py-2 rounded-lg transition text-sm">
        <i class="fas fa-save"></i>
        {{ $product->exists ? 'Simpan Perubahan' : 'Tambah Produk' }}
    </button>
    <a href="{{ route('admin.produk.index') }}"
       class="inline-flex items-center gap-2 border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold px-5 py-2 rounded-lg transition text-sm">
        <i class="fas fa-times"></i> Batal
    </a>
</div>

@push('scripts')
<script>
function previewImage(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('preview-img').src = e.target.result;
        document.getElementById('preview-wrap').style.display = '';
    };
    reader.readAsDataURL(input.files[0]);
}

function previewGallery(input) {
    const container = document.getElementById('gallery-preview');
    if (!container) return;
    container.innerHTML = '';
    Array.from(input.files || []).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.cssText = 'width:52px;height:68px;object-fit:cover;border-radius:.4rem;box-shadow:0 1px 2px rgba(0,0,0,.15);border:1px solid #e5e7eb;';
            container.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
}
</script>
@endpush

@endsection
