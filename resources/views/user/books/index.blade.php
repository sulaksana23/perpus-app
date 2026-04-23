@extends('layouts.user', ['title' => 'Daftar Buku'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <form method="GET" class="row g-2 w-100 card p-3">
        <div class="col-md-5"><input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Cari judul/kode/pengarang"></div>
        <div class="col-md-4">
            <select name="category_id" class="form-select">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected((int)$categoryId === $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3"><button class="btn btn-outline-primary w-100"><i class="bi bi-search me-1"></i>Cari</button></div>
    </form>
</div>

<div class="row g-3">
    @forelse($books as $book)
        @php
            $hasActiveSameTitle = in_array($book->title, $activeTitles, true);
            $canBorrow = $book->stock > 0 && ! $hasActiveSameTitle;
        @endphp
        <div class="col-sm-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <h6 class="fw-bold">{{ $book->title }}</h6>
                    <p class="small text-muted mb-1">{{ $book->author ?: '-' }}</p>
                    <p class="small mb-1">Kode: {{ $book->code ?: '-' }}</p>
                    <p class="small mb-2"><i class="bi bi-box-seam me-1"></i>Stok: {{ $book->stock }}</p>
                    <div class="mt-auto d-flex gap-2">
                        <a href="{{ route('user.books.show', $book) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye me-1"></i>Detail</a>
                        <a href="{{ route('user.loans.create', ['book_id' => $book->id]) }}" class="btn btn-sm btn-primary {{ $canBorrow ? '' : 'disabled' }}"><i class="bi bi-journal-arrow-up me-1"></i>Pinjam</a>
                    </div>
                    @if(! $canBorrow)
                        <small class="text-danger mt-2">{{ $book->stock < 1 ? 'Stok habis' : 'Anda masih punya pinjaman aktif dengan judul ini' }}</small>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12"><div class="alert alert-info">Buku tidak ditemukan.</div></div>
    @endforelse
</div>
<div class="mt-3">{{ $books->links() }}</div>
@endsection
