@extends('layouts.admin')

@section('title', $product->exists ? 'Edit Produk' : 'Tambah Produk')
@section('page-title', $product->exists ? 'Edit Produk' : 'Tambah Produk Baru')
@section('page-subtitle', $product->exists ? 'Perbarui data produk' : 'Isi data buku baru untuk katalog')

@section('content')

<div class="max-w-3xl">
    <form method="POST"
          action="{{ $product->exists ? route('admin.produk.update', $product) : route('admin.produk.store') }}"
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        @if($product->exists)
        @method('PUT')
        @endif

        <div class="bg-white rounded-xl shadow p-6 space-y-5">
            <h3 class="font-bold text-gray-700 text-sm uppercase tracking-wide border-b border-gray-100 pb-3">Informasi Buku</h3>

            {{-- Judul --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Buku <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ old('judul', $product->judul) }}" required
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('judul') border-red-400 @enderror"
                       placeholder="Masukkan judul buku">
                @error('judul')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Penulis --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Penulis</label>
                <input type="text" name="penulis" value="{{ old('penulis', $product->penulis) }}"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                       placeholder="Nama penulis">
            </div>

            {{-- Kategori & Jenjang --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori</label>
                    <select name="category_id"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">-- Tanpa Kategori --</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jenjang</label>
                    <select name="jenjang"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">-- Pilih Jenjang --</option>
                        @foreach(['SD', 'SMP', 'SMA', 'SMK', 'Umum'] as $j)
                        <option value="{{ $j }}" {{ old('jenjang', $product->jenjang) === $j ? 'selected' : '' }}>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Kelas & Tahun --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kelas</label>
                    <input type="text" name="kelas" value="{{ old('kelas', $product->kelas) }}"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                           placeholder="Contoh: 7, 8, 9 atau 1-3">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tahun Terbit</label>
                    <input type="number" name="tahun" value="{{ old('tahun', $product->tahun) }}"
                           min="2000" max="2100"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                           placeholder="{{ date('Y') }}">
                </div>
            </div>

            {{-- ISBN --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">ISBN</label>
                <input type="text" name="isbn" value="{{ old('isbn', $product->isbn) }}"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                       placeholder="Nomor ISBN buku">
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                <textarea name="deskripsi" rows="4"
                          class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 resize-y"
                          placeholder="Deskripsi singkat buku...">{{ old('deskripsi', $product->deskripsi) }}</textarea>
            </div>
        </div>

        {{-- Cover Image --}}
        <div class="bg-white rounded-xl shadow p-6 space-y-4">
            <h3 class="font-bold text-gray-700 text-sm uppercase tracking-wide border-b border-gray-100 pb-3">Cover Buku</h3>
            <div class="flex gap-6 items-start">
                <div id="preview-wrap" class="{{ $product->exists ? 'block' : 'hidden' }}">
                    <img id="preview-img" src="{{ $product->exists ? $product->cover_url : '' }}"
                         alt="Preview" class="w-24 h-32 object-cover rounded-lg shadow">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Upload Cover {{ $product->exists ? '(biarkan kosong jika tidak diubah)' : '' }}
                    </label>
                    <input type="file" name="cover_image" id="cover_image" accept="image/*"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                           onchange="previewImage(this)">
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WebP. Maks 2MB.</p>
                    @error('cover_image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Settings --}}
        <div class="bg-white rounded-xl shadow p-6 space-y-4">
            <h3 class="font-bold text-gray-700 text-sm uppercase tracking-wide border-b border-gray-100 pb-3">Pengaturan</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Urutan Tampil</label>
                    <input type="number" name="urutan" value="{{ old('urutan', $product->urutan ?? 0) }}" min="0"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                           placeholder="0">
                    <p class="text-xs text-gray-400 mt-1">Angka kecil tampil lebih dulu</p>
                </div>
                <div class="flex items-center gap-3 pt-6">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                               {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-900"></div>
                        <span class="ml-3 text-sm font-semibold text-gray-700">Produk Aktif</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="flex gap-3">
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-900 hover:bg-blue-800 text-white font-semibold px-6 py-2.5 rounded-lg transition text-sm">
                <i class="fas fa-save"></i>
                {{ $product->exists ? 'Simpan Perubahan' : 'Tambah Produk' }}
            </button>
            <a href="{{ route('admin.produk.index') }}"
               class="inline-flex items-center gap-2 border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold px-6 py-2.5 rounded-lg transition text-sm">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('preview-wrap').classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

@endsection
