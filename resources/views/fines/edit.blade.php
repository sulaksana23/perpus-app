@extends('layouts.app', ['title' => 'Edit Denda'])

@section('content')
<section class="mx-auto max-w-xl rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <h1 class="mb-4 text-xl font-bold">Edit Denda</h1>
    <form action="{{ route('fines.update', $fine) }}" method="POST" class="space-y-4">@csrf @method('PUT')
        <div><label class="mb-1 block text-sm">Nama Denda</label><input name="name" class="w-full rounded border px-3 py-2" value="{{ old('name', $fine->name) }}" required></div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div><label class="mb-1 block text-sm">Nominal</label><input name="amount" type="number" min="0" class="w-full rounded border px-3 py-2" value="{{ old('amount', $fine->amount) }}" required></div>
            <div><label class="mb-1 block text-sm">Tipe</label><select name="type" class="w-full rounded border px-3 py-2">@foreach(['fixed','per_day','percentage','full_price'] as $type)<option value="{{ $type }}" @selected(old('type',$fine->type)===$type)>{{ $type }}</option>@endforeach</select></div>
        </div>
        <div><label class="mb-1 block text-sm">Deskripsi</label><textarea name="description" class="w-full rounded border px-3 py-2">{{ old('description', $fine->description) }}</textarea></div>
        <label class="inline-flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $fine->is_active))>Aktif</label>
        <div class="flex gap-2"><button class="rounded bg-blue-600 px-3 py-2 text-sm text-white">Update</button><a href="{{ route('fines.index') }}" class="rounded border px-3 py-2 text-sm">Batal</a></div>
    </form>
</section>
@endsection
