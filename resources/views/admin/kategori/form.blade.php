@extends('layouts.admin')

@section('title', $category->exists ? 'Edit Kategori' : 'Tambah Kategori')
@section('page-title', $category->exists ? 'Edit Kategori' : 'Tambah Kategori Baru')

@section('content')

<div class="max-w-lg">
    <form method="POST"
          action="{{ $category->exists ? route('admin.kategori.update', $category) : route('admin.kategori.store') }}"
          class="space-y-5">
        @csrf
        @if($category->exists)
        @method('PUT')
        @endif

        <div class="bg-white rounded-xl shadow p-6 space-y-5">

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('name') border-red-400 @enderror"
                       placeholder="Contoh: Buku Matematika">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Ikon Emoji --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Ikon</label>
                <div class="flex gap-2 items-center mb-2">
                    <div id="icon-preview"
                         style="width:2.5rem;height:2.5rem;font-size:1.5rem;display:flex;align-items:center;justify-content:center;border:1px solid #e5e7eb;border-radius:.5rem;background:#f9fafb;">
                        {{ old('icon', $category->icon) ?: '—' }}
                    </div>
                    <input type="text" name="icon" id="icon-input" value="{{ old('icon', $category->icon) }}"
                           class="w-24 border border-gray-200 rounded-lg px-3 py-2 text-sm text-center focus:outline-none focus:ring-2 focus:ring-blue-400"
                           placeholder="emoji"
                           oninput="document.getElementById('icon-preview').textContent = this.value || '—'">
                    <button type="button" onclick="document.getElementById('icon-input').value=''; document.getElementById('icon-preview').textContent='—';"
                            class="text-xs text-gray-400 hover:text-red-500 transition">Hapus</button>
                </div>

                {{-- Grid emoji --}}
                <div style="border:1px solid #e5e7eb;border-radius:.5rem;padding:.5rem;background:#f9fafb;">
                    <p style="font-size:.7rem;color:#6b7280;margin-bottom:.4rem;font-weight:600;">Klik emoji untuk pilih:</p>
                    @php
                    $emojiGroups = [
                        'Buku & Pendidikan' => ['📚','📖','📝','✏️','🖊️','📓','📔','📒','📕','📗','📘','📙','📜','📄','🎓','🏫','🔬','🔭','🧪','🧮'],
                        'Kategori & Label'  => ['🏷️','📌','📍','🗂️','🗃️','📂','📁','🗄️','📋','🗒️','📊','📈','📉','🔖','🏅','⭐','🌟','✅','🎯','💡'],
                        'Produk Cetak'      => ['🖨️','🖼️','🎨','✂️','📰','🗞️','📷','📸','🎞️','🖋️','📏','📐','🔗','📦','🎁','🗓️','📅','📆','🗑️','🔑'],
                        'Jenjang & Umum'    => ['👶','🧒','👦','👧','🧑','👩','👨','👴','👵','🌱','🌿','🌳','🏡','🏙️','🌍','⚡','🔥','💎','🏆','🎖️'],
                    ];
                    @endphp
                    @foreach($emojiGroups as $groupName => $emojis)
                    <p style="font-size:.65rem;color:#9ca3af;margin:.4rem 0 .2rem;text-transform:uppercase;letter-spacing:.04em;">{{ $groupName }}</p>
                    <div style="display:flex;flex-wrap:wrap;gap:.2rem;margin-bottom:.3rem;">
                        @foreach($emojis as $emoji)
                        <button type="button"
                                onclick="pickEmoji('{{ $emoji }}')"
                                title="{{ $emoji }}"
                                style="font-size:1.3rem;width:2rem;height:2rem;display:flex;align-items:center;justify-content:center;border:1px solid transparent;border-radius:.375rem;cursor:pointer;background:transparent;transition:background .15s;"
                                onmouseover="this.style.background='#e0e7ff';this.style.borderColor='#818cf8'"
                                onmouseout="this.style.background='transparent';this.style.borderColor='transparent'">{{ $emoji }}</button>
                        @endforeach
                    </div>
                    @endforeach
                </div>
                <p class="text-xs text-gray-400 mt-1">Opsional. Ikon tampil di halaman katalog.</p>
            </div>

            {{-- Urutan --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Urutan Tampil</label>
                <input type="number" name="urutan" value="{{ old('urutan', $category->urutan ?? 0) }}" min="0"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <p class="text-xs text-gray-400 mt-1">Angka kecil tampil lebih dulu. Isi 1 agar tampil paling depan (kategori lain otomatis digeser).</p>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-900 hover:bg-blue-800 text-white font-semibold px-6 py-2.5 rounded-lg transition text-sm">
                <i class="fas fa-save"></i>
                {{ $category->exists ? 'Simpan Perubahan' : 'Tambah Kategori' }}
            </button>
            <a href="{{ route('admin.kategori.index') }}"
               class="inline-flex items-center gap-2 border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold px-6 py-2.5 rounded-lg transition text-sm">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function pickEmoji(emoji) {
    document.getElementById('icon-input').value = emoji;
    document.getElementById('icon-preview').textContent = emoji;
}
</script>
@endpush

@endsection
