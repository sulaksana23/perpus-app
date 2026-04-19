@extends('layouts.app', ['title' => 'Edit Kategori'])

@section('content')
<section class="mx-auto max-w-xl rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <h1 class="mb-4 text-xl font-bold">Edit Kategori</h1>
    <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-4">@csrf @method('PUT')
        <div><label class="mb-1 block text-sm">Nama</label><input name="name" value="{{ old('name', $category->name) }}" class="w-full rounded border px-3 py-2" required></div>
        <div><label class="mb-1 block text-sm">Deskripsi</label><textarea name="description" class="w-full rounded border px-3 py-2">{{ old('description', $category->description) }}</textarea></div>
        <label class="inline-flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active))>Aktif</label>
        <div class="flex gap-2"><button class="rounded bg-blue-600 px-3 py-2 text-sm text-white">Update</button><a href="{{ route('categories.index') }}" class="rounded border px-3 py-2 text-sm">Batal</a></div>
    </form>
</section>
@endsection
