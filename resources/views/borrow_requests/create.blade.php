@extends('layouts.app', ['title' => 'Ajukan Peminjaman'])

@section('content')
    <section class="mx-auto max-w-2xl rounded-xl border border-slate-200 bg-white p-4 shadow-sm md:p-5">
        <h1 class="mb-2 text-xl font-bold text-slate-900">Ajukan Peminjaman Buku</h1>
        <p class="mb-4 text-sm text-slate-500">Pilih buku yang ingin dipinjam, pengajuan akan direview admin.</p>

        <form action="{{ route('borrow-requests.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="mb-1 block text-sm font-medium" for="book_id">Buku</label>
                <select class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" id="book_id" name="book_id" required>
                    <option value="">Pilih buku</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" @selected(old('book_id') == $book->id)>{{ $book->title }} - {{ $book->author }} (stok: {{ $book->stock }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium" for="notes">Catatan (opsional)</label>
                <textarea class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700">Kirim Pengajuan</button>
                <a href="{{ route('dashboard') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
            </div>
        </form>
    </section>
@endsection
