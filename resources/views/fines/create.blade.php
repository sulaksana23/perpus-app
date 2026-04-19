@extends('layouts.app', ['title' => 'Tambah Denda'])

@section('content')
<section class="mx-auto max-w-xl rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <h1 class="mb-4 text-xl font-bold">Tambah Denda</h1>
    <form action="{{ route('fines.store') }}" method="POST" class="space-y-4">@csrf
        <div><label class="mb-1 block text-sm">Nama Denda</label><input name="name" class="w-full rounded border px-3 py-2" value="{{ old('name') }}" required></div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div><label class="mb-1 block text-sm">Nominal</label><input name="amount" type="number" min="0" class="w-full rounded border px-3 py-2" value="{{ old('amount', 0) }}" required></div>
            <div><label class="mb-1 block text-sm">Tipe</label><select name="type" class="w-full rounded border px-3 py-2"><option value="fixed">fixed</option><option value="per_day">per_day</option><option value="percentage">percentage</option><option value="full_price">full_price</option></select></div>
        </div>
        <div><label class="mb-1 block text-sm">Deskripsi</label><textarea name="description" class="w-full rounded border px-3 py-2">{{ old('description') }}</textarea></div>
        <label class="inline-flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" checked>Aktif</label>
        <div class="flex gap-2"><button class="rounded bg-blue-600 px-3 py-2 text-sm text-white">Simpan</button><a href="{{ route('fines.index') }}" class="rounded border px-3 py-2 text-sm">Batal</a></div>
    </form>
</section>
@endsection
