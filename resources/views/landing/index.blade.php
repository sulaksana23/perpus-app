@extends('layouts.guest', ['title' => 'Landing Page'])

@section('content')
<div class="mb-2 p-3 rounded-4 text-white" style="background: linear-gradient(120deg, #0f766e, #0ea5a4 65%, #0891b2);">
    <h1 class="h5 fw-bold mb-1"><i class="bi bi-stars me-2"></i>Sistem Perpustakaan Digital</h1>
    <p class="mb-0 opacity-75 small">Cari buku cepat berdasarkan judul, kategori, kode, atau pengarang.</p>
</div>

<form method="GET" class="card p-2 mb-2">
    <div class="row g-1 align-items-center">
        <div class="col-12 col-lg-6">
            <input type="text" name="q" value="{{ $search }}" class="form-control" style="min-height: 38px;" placeholder="Cari judul / kode / pengarang">
        </div>
        <div class="col-12 col-md-7 col-lg-4">
            <select name="category_id" class="form-select" style="min-height: 38px;">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected((int)$categoryId === $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-5 col-lg-2 d-grid">
            <button class="btn btn-primary" style="min-height: 38px;" type="submit"><i class="bi bi-search me-1"></i>Cari</button>
        </div>
    </div>
</form>

<div class="row g-2">
    @forelse($books as $book)
        <div class="col-sm-6 col-lg-3">
            <div class="card h-100">
                @if($book->cover)
                    <img loading="lazy" src="{{ asset('storage/'.$book->cover) }}" class="card-img-top" alt="{{ $book->title }}" style="height: 130px; object-fit: cover;">
                @else
                    <div class="d-flex align-items-center justify-content-center text-secondary small" style="height: 130px; background: linear-gradient(135deg, #ecfeff, #dbeafe);">
                        <span class="fw-semibold">No Cover</span>
                    </div>
                @endif
                <div class="card-body p-2">
                    <h6 class="card-title fw-bold mb-0 text-truncate">{{ $book->title }}</h6>
                    <p class="small text-muted mb-0 text-truncate">{{ $book->author ?: '-' }}</p>
                    <p class="small mb-0 text-truncate">Kode: {{ $book->code ?: '-' }}</p>
                    <p class="small mb-1 text-truncate">Kategori: {{ $book->category?->name ?: '-' }}</p>
                    <span class="badge {{ $book->stock > 0 ? 'text-bg-success' : 'text-bg-danger' }} mb-1"><i class="bi bi-box-seam me-1"></i>{{ $book->stock }}</span>
                    <div class="d-flex gap-1">
                        <a href="{{ route('landing.books.show', $book) }}" class="btn btn-sm btn-outline-secondary flex-fill text-center"><i class="bi bi-eye me-1"></i>Detail</a>
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-sm btn-primary flex-fill text-center"><i class="bi bi-box-arrow-in-right me-1"></i>Login</a>
                        @else
                            <a href="{{ route('user.loans.create', ['book_id' => $book->id]) }}" class="btn btn-sm btn-primary flex-fill text-center"><i class="bi bi-journal-arrow-up me-1"></i>Pinjam</a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">Buku belum tersedia.</div>
        </div>
    @endforelse
</div>

<div class="mt-2">
    {{ $books->links() }}
</div>
@endsection
