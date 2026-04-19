@extends('layouts.app', ['title' => 'Tambah Buku'])

@section('content')
    <section class="mx-auto max-w-4xl rounded-xl border border-slate-200 bg-white p-4 shadow-sm md:p-5">
        <h1 class="mb-4 text-xl font-bold text-slate-900">Tambah Buku</h1>

        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">@csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div><label class="mb-1 block text-sm">Kode Buku</label><input name="code" value="{{ old('code') }}" class="w-full rounded border px-3 py-2" required></div>
                <div><label class="mb-1 block text-sm">Judul</label><input name="title" value="{{ old('title') }}" class="w-full rounded border px-3 py-2" required></div>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div><label class="mb-1 block text-sm">Penulis</label><input name="author" value="{{ old('author') }}" class="w-full rounded border px-3 py-2" required></div>
                <div><label class="mb-1 block text-sm">Penerbit</label><input name="publisher" value="{{ old('publisher') }}" class="w-full rounded border px-3 py-2"></div>
                <div><label class="mb-1 block text-sm">Tahun Terbit</label><input type="number" name="published_year" value="{{ old('published_year') }}" class="w-full rounded border px-3 py-2"></div>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div><label class="mb-1 block text-sm">ISBN</label><input name="isbn" value="{{ old('isbn') }}" class="w-full rounded border px-3 py-2"></div>
                <div><label class="mb-1 block text-sm">Kategori</label><select name="category_id" class="w-full rounded border px-3 py-2"><option value="">Pilih Kategori</option>@foreach($categories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach</select></div>
                <div><label class="mb-1 block text-sm">Rak</label><input name="rack" value="{{ old('rack') }}" class="w-full rounded border px-3 py-2"></div>
            </div>
            <div><label class="mb-1 block text-sm">Deskripsi</label><textarea name="description" rows="4" class="w-full rounded border px-3 py-2">{{ old('description') }}</textarea></div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <div><label class="mb-1 block text-sm">Cover</label><input type="file" name="cover" accept="image/*" class="w-full rounded border px-3 py-2"></div>
                <div><label class="mb-1 block text-sm">Stok</label><input type="number" min="0" name="stock" value="{{ old('stock',0) }}" class="w-full rounded border px-3 py-2" required></div>
                <div><label class="mb-1 block text-sm">Status</label><select name="status" class="w-full rounded border px-3 py-2"><option value="tersedia">Tersedia</option><option value="habis">Habis</option></select></div>
                <div><label class="mb-1 block text-sm">Harga Buku</label><input type="number" min="0" name="price" value="{{ old('price',0) }}" class="w-full rounded border px-3 py-2"></div>
            </div>
            <div class="flex gap-2"><button class="rounded bg-blue-600 px-3 py-2 text-sm text-white">Simpan</button><a href="{{ route('books.index') }}" class="rounded border px-3 py-2 text-sm">Batal</a></div>
        </form>
    </section>
@endsection
