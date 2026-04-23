@extends('layouts.user', ['title' => 'Detail Buku'])

@section('content')
<div class="card">
    <div class="card-body">
        <h4>{{ $book->title }}</h4>
        <p class="mb-1">Kode: {{ $book->code ?: '-' }}</p>
        <p class="mb-1">Pengarang: {{ $book->author ?: '-' }}</p>
        <p class="mb-1">Kategori: {{ $book->category?->name ?: '-' }}</p>
        <p class="mb-1">Stok: {{ $book->stock }}</p>
        <p class="mb-3">Deskripsi: {{ $book->description ?: '-' }}</p>

        <div class="d-flex gap-2">
            <a href="{{ route('user.books.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            <a href="{{ route('user.loans.create', ['book_id' => $book->id]) }}" class="btn btn-primary {{ $book->stock < 1 ? 'disabled' : '' }}">
                <i class="bi bi-journal-arrow-up me-1"></i>{{ $book->stock < 1 ? 'Stok Habis' : 'Pinjam Buku Ini' }}
            </a>
        </div>
    </div>
</div>
@endsection
