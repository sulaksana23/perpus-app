@extends('layouts.app', ['title' => 'Tambah Kategori'])

@section('content')
<section class="mx-auto max-w-xl rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <h1 class="mb-4 text-xl font-bold">Tambah Kategori</h1>
    <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">@csrf
        <div><label class="mb-1 block text-sm">Nama</label><input name="name" value="{{ old('name') }}" class="w-full rounded border px-3 py-2" required></div>
        <div><label class="mb-1 block text-sm">Deskripsi</label><textarea name="description" class="w-full rounded border px-3 py-2">{{ old('description') }}</textarea></div>
        <label class="inline-flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" checked>Aktif</label>
        <div class="flex gap-2"><button class="rounded bg-blue-600 px-3 py-2 text-sm text-white">Simpan</button><a href="{{ route('categories.index') }}" class="rounded border px-3 py-2 text-sm">Batal</a></div>
    </form>
</section>
@endsection
