@extends('layouts.app', ['title' => 'Tambah Transaksi'])

@section('content')
<section class="mx-auto max-w-4xl rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <h1 class="mb-4 text-xl font-bold">Tambah Transaksi</h1>
    <form action="{{ route('transactions.store') }}" method="POST" class="space-y-4">@csrf
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div><label class="mb-1 block text-sm">Kode</label><input name="code" value="{{ old('code') }}" class="w-full rounded border px-3 py-2"></div>
            <div><label class="mb-1 block text-sm">Anggota</label><select name="member_id" class="w-full rounded border px-3 py-2" required>@foreach($members as $member)<option value="{{ $member->id }}">{{ $member->name }}</option>@endforeach</select></div>
            <div><label class="mb-1 block text-sm">Buku</label><select name="book_id" class="w-full rounded border px-3 py-2" required>@foreach($books as $book)<option value="{{ $book->id }}">{{ $book->title }}</option>@endforeach</select></div>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div><label class="mb-1 block text-sm">Request</label><select name="borrow_request_id" class="w-full rounded border px-3 py-2"><option value="">Tanpa Request</option>@foreach($requests as $req)<option value="{{ $req->id }}">{{ $req->code }}</option>@endforeach</select></div>
            <div><label class="mb-1 block text-sm">Tanggal Pinjam</label><input type="date" name="borrowed_at" value="{{ old('borrowed_at', now()->toDateString()) }}" class="w-full rounded border px-3 py-2" required></div>
            <div><label class="mb-1 block text-sm">Batas Kembali</label><input type="date" name="due_at" value="{{ old('due_at', now()->addDays(7)->toDateString()) }}" class="w-full rounded border px-3 py-2" required></div>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div><label class="mb-1 block text-sm">Perpanjang Sampai</label><input type="date" name="extended_until" value="{{ old('extended_until') }}" class="w-full rounded border px-3 py-2"></div>
            <div><label class="mb-1 block text-sm">Tanggal Kembali</label><input type="date" name="returned_at" value="{{ old('returned_at') }}" class="w-full rounded border px-3 py-2"></div>
            <div><label class="mb-1 block text-sm">Status</label><select name="status" class="w-full rounded border px-3 py-2">@foreach($statuses as $item)<option value="{{ $item }}">{{ strtoupper($item) }}</option>@endforeach</select></div>
        </div>
        <div><label class="mb-1 block text-sm">Catatan</label><textarea name="notes" class="w-full rounded border px-3 py-2">{{ old('notes') }}</textarea></div>
        <div class="flex gap-2"><button class="rounded bg-blue-600 px-3 py-2 text-sm text-white">Simpan</button><a href="{{ route('transactions.index') }}" class="rounded border px-3 py-2 text-sm">Batal</a></div>
    </form>
</section>
@endsection
