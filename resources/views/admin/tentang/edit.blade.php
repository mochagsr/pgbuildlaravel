@extends('layouts.admin')

@section('title', 'Kelola Halaman Tentang')
@section('page-title', 'Halaman Tentang')
@section('page-subtitle', 'Kelola teks, cover, dan galeri kegiatan')

@push('scripts')
<style>
.tentang-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.25rem;
    align-items: start;
}
@media (min-width: 1100px) {
    .tentang-grid { grid-template-columns: 1fr 1fr; }
}
.form-input {
    width: 100%; border: 1px solid #e5e7eb; border-radius: 0.5rem;
    padding: 0.45rem 0.75rem; font-size: 0.8125rem; outline: none; box-sizing: border-box;
}
.form-input:focus { box-shadow: 0 0 0 2px #93c5fd; border-color: #93c5fd; }
.form-label { display: block; font-size: 0.75rem; font-weight: 600; color: #374151; margin-bottom: 0.35rem; }
.card { background: #fff; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,.08); padding: 1rem 1.125rem; }
.card-title { font-size: 0.7rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: .06em; border-bottom: 1px solid #f3f4f6; padding-bottom: 0.5rem; margin-bottom: 0.875rem; }
.btn-save { background:#1e3a5f;color:#fff;border:none;padding:.5rem 1.25rem;border-radius:.5rem;font-size:.8125rem;font-weight:600;cursor:pointer; }
.btn-save:hover { background:#1e40af; }
</style>
@endpush

@section('content')

{{-- Satu form untuk cover + teks --}}
<form method="POST" action="{{ route('admin.tentang.update') }}" enctype="multipart/form-data">
@csrf

<div class="tentang-grid" style="margin-bottom:1.25rem;">

    {{-- Kolom Kiri: Cover + Teks --}}
    <div style="display:flex;flex-direction:column;gap:1rem;">

        {{-- Cover --}}
        <div class="card">
            <div class="card-title">Gambar Cover</div>
            <p style="font-size:.72rem;color:#6b7280;margin-bottom:.6rem;">
                Gambar di sebelah kiri teks "Perkenalkan Kami..."
            </p>
            <div style="display:flex;gap:.75rem;align-items:flex-start;">
                <div style="flex-shrink:0;">
                    <img id="cover-preview" src="{{ $setting->cover_url }}" alt="Cover"
                         style="width:90px;height:120px;object-fit:cover;border-radius:.5rem;box-shadow:0 1px 3px rgba(0,0,0,.15);">
                </div>
                <div style="flex:1;min-width:0;">
                    <label class="form-label">Ganti Cover <span style="font-weight:400;color:#9ca3af;">(kosong = tidak diubah)</span></label>
                    <input type="file" name="cover_image" accept="image/*"
                           class="form-input" onchange="previewCover(this)">
                    <p style="font-size:.7rem;color:#9ca3af;margin-top:.25rem">JPG, PNG, WebP. Maks 5MB.</p>
                    @error('cover_image')<p style="color:#ef4444;font-size:.7rem;margin-top:.25rem">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Teks Tentang --}}
        <div class="card">
            <div class="card-title">Teks Tentang</div>
            <p style="font-size:.72rem;color:#6b7280;margin-bottom:.6rem;">
                Isi paragraf yang tampil di halaman Tentang. Pisahkan paragraf dengan baris kosong (Enter 2x).
            </p>
            <label class="form-label">Konten</label>
            <textarea name="content" rows="14" class="form-input" style="resize:vertical;line-height:1.6;">{{ old('content', $setting->content ?? "Sebuah usaha berbentuk perseroan komanditer yang dimotori sekelompok tenaga profesional muda. Didirikan tahun 2007 dengan komitmen memberikan layanan pengadaan barang dan jasa di bidang pendidikan pada instansi pemerintah maupun swasta.

Kami mengkhususkan diri sebagai produsen percetakan offset dan penyedia buku (alat peraga pendidikan) yang telah eksis bertahun-tahun memberikan pelayanan dalam meningkatkan mutu proses belajar mengajar. Dalam hal ini pengadaan buku-buku pelajaran atau bahan ajar, mulai jenjang pendidikan Sekolah Dasar, Sekolah Lanjutan Menengah Pertama, Sekolah Menengah Atas ataupun Kejuruan.

Kami telah membantu beberapa instansi dan sekolah dari tingkat sekolah dasar sampai sekolah menengah atas dalam percetakan dan merealisasikan pengadaannya. Kami berpengalaman di dunia percetakan dan pengadaan penunjang pembelajaran.

Dengan semangat \"Mitra Mencerdaskan Anak Bangsa\", kami PUSTAKA GRAFIKA selalu mengutamakan mutu dan kualitas, selalu update dan pioneer dalam percetakan untuk memberikan kemudahan dan kenyamanan para pengguna jasa.") }}</textarea>
            <p style="font-size:.7rem;color:#9ca3af;margin-top:.25rem">Paragraf baru = baris kosong di antara teks.</p>
        </div>

    </div>

    {{-- Kolom Kanan: Galeri --}}
    <div class="card">
        <div class="card-title">
            Galeri Gambar <span style="font-weight:400;font-size:.65rem;color:#9ca3af;text-transform:none;letter-spacing:0;">(tampil di halaman Tentang)</span>
        </div>

        @if($images->count())
            {{-- Gambar dari DB — bisa dihapus --}}
            <div style="display:grid;grid-template-columns:repeat(6,1fr);gap:.35rem;margin-bottom:.75rem;">
                @foreach($images as $img)
                <div style="position:relative;"
                     onmouseover="this.querySelector('.del-btn').style.opacity='1'"
                     onmouseout="this.querySelector('.del-btn').style.opacity='0'">
                    <img src="{{ $img->url }}" style="width:100%;aspect-ratio:1;object-fit:cover;border-radius:.35rem;box-shadow:0 1px 2px rgba(0,0,0,.1);">
                    <button type="button" class="del-btn"
                            data-url="{{ route('admin.tentang.images.destroy', $img) }}"
                            onclick="deleteGalleryImage(this)"
                            style="position:absolute;top:2px;right:2px;opacity:0;transition:opacity .15s;background:#ef4444;color:#fff;border:none;border-radius:50%;width:18px;height:18px;display:flex;align-items:center;justify-content:center;font-size:.55rem;cursor:pointer;line-height:1;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @endforeach
            </div>
        @else
            {{-- Gambar lama dari folder — tampil kecil, ada tombol import --}}
            @php
                $staticImgs = array_values(array_filter(
                    array_map(fn($f) => "images/tentang/{$f}.jpg", ['t2','t3','t4','t5','t6','t7','t8','t9','t10','t11','t12','t13']),
                    fn($p) => file_exists(public_path($p))
                ));
            @endphp
            @if(count($staticImgs))
            <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:.5rem;padding:.5rem .75rem;margin-bottom:.6rem;font-size:.72rem;color:#92400e;display:flex;align-items:center;justify-content:space-between;gap:.5rem;flex-wrap:wrap;">
                <span><i class="fas fa-info-circle"></i> Gambar lama dari folder. Klik tombol untuk mengaktifkan tombol hapus.</span>
                <button type="button" id="import-btn" onclick="importStatic()"
                        style="background:#92400e;color:#fff;border:none;padding:.3rem .75rem;border-radius:.4rem;font-size:.72rem;cursor:pointer;white-space:nowrap;">
                    <i class="fas fa-database"></i> Pakai Gambar Ini
                </button>
            </div>
            <p id="import-msg" style="font-size:.7rem;display:none;margin-bottom:.5rem;"></p>
            <div style="display:grid;grid-template-columns:repeat(6,1fr);gap:.35rem;margin-bottom:.75rem;">
                @foreach($staticImgs as $p)
                <div>
                    <img src="{{ asset($p) }}" style="width:100%;aspect-ratio:1;object-fit:cover;border-radius:.35rem;box-shadow:0 1px 2px rgba(0,0,0,.1);">
                </div>
                @endforeach
            </div>
            @else
            <p style="font-size:.75rem;color:#9ca3af;margin-bottom:.75rem;">Belum ada gambar galeri.</p>
            @endif
        @endif

        {{-- Upload via fetch --}}
        <div>
            <label class="form-label">Tambah Gambar</label>
            <div style="display:flex;gap:.5rem;align-items:center;">
                <input type="file" id="gallery-files" multiple accept="image/*"
                       class="form-input" style="flex:1;min-width:0;">
                <button type="button" onclick="uploadGallery()" id="gallery-btn"
                        style="flex-shrink:0;background:#1e3a5f;color:#fff;border:none;padding:.45rem .85rem;border-radius:.5rem;font-size:.8rem;cursor:pointer;">
                    <i class="fas fa-upload"></i> Upload
                </button>
            </div>
            <p id="gallery-msg" style="font-size:.7rem;color:#9ca3af;margin-top:.25rem">Bisa pilih lebih dari 1. Maks 5MB.</p>
        </div>
    </div>

</div>{{-- /tentang-grid --}}

{{-- Tombol simpan (cover + teks) --}}
<div style="display:flex;gap:.75rem;">
    <button type="submit" class="btn-save">
        <i class="fas fa-save" style="margin-right:.3rem;"></i> Simpan Cover & Teks
    </button>
    <a href="{{ route('admin.dashboard') }}"
       class="inline-flex items-center gap-2 border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold px-5 py-2 rounded-lg transition text-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

</form>

@push('scripts')
<script>
function previewCover(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => { document.getElementById('cover-preview').src = e.target.result; };
    reader.readAsDataURL(input.files[0]);
}

async function deleteGalleryImage(btn) {
    if (!confirm('Hapus gambar ini?')) return;
    btn.disabled = true;
    try {
        const fd = new FormData();
        fd.append('_token', '{{ csrf_token() }}');
        fd.append('_method', 'DELETE');
        const res = await fetch(btn.dataset.url, { method: 'POST', body: fd });
        if (res.ok || res.redirected) {
            btn.closest('div').remove();
        } else {
            alert('Gagal menghapus. Status: ' + res.status);
            btn.disabled = false;
        }
    } catch(err) {
        alert('Error: ' + err.message);
        btn.disabled = false;
    }
}

async function importStatic() {
    const btn = document.getElementById('import-btn');
    const msg = document.getElementById('import-msg');
    btn.disabled = true;
    btn.textContent = 'Mengimpor...';
    msg.style.display = 'block';
    msg.style.color = '#9ca3af';
    msg.textContent = 'Sedang mengimpor gambar...';
    try {
        const fd = new FormData();
        fd.append('_token', '{{ csrf_token() }}');
        const res = await fetch('{{ route('admin.tentang.images.import') }}', { method: 'POST', body: fd });
        if (res.ok || res.redirected) {
            msg.style.color = '#16a34a';
            msg.textContent = 'Berhasil! Memuat ulang...';
            setTimeout(() => window.location.reload(), 800);
        } else {
            msg.style.color = '#ef4444';
            msg.textContent = 'Gagal. Status: ' + res.status;
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-database"></i> Pakai Gambar Ini';
        }
    } catch(err) {
        msg.style.color = '#ef4444';
        msg.textContent = 'Error: ' + err.message;
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-database"></i> Pakai Gambar Ini';
    }
}

async function uploadGallery() {
    const input = document.getElementById('gallery-files');
    const btn   = document.getElementById('gallery-btn');
    const msg   = document.getElementById('gallery-msg');

    if (!input.files.length) {
        msg.textContent = 'Pilih gambar terlebih dahulu.';
        msg.style.color = '#ef4444';
        return;
    }

    const fd = new FormData();
    Array.from(input.files).forEach(f => fd.append('images[]', f));
    fd.append('_token', '{{ csrf_token() }}');

    btn.disabled = true;
    btn.textContent = 'Mengupload...';
    msg.style.color = '#9ca3af';
    msg.textContent = 'Sedang mengupload...';

    try {
        const res = await fetch('{{ route('admin.tentang.images.store') }}', {
            method: 'POST', body: fd,
        });
        if (res.ok || res.redirected) {
            msg.style.color = '#16a34a';
            msg.textContent = 'Berhasil! Memuat ulang...';
            setTimeout(() => window.location.reload(), 800);
        } else {
            msg.style.color = '#ef4444';
            msg.textContent = 'Gagal upload. Status: ' + res.status;
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-upload"></i> Upload';
        }
    } catch (err) {
        msg.style.color = '#ef4444';
        msg.textContent = 'Error: ' + err.message;
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-upload"></i> Upload';
    }
}
</script>
@endpush

@endsection
