@extends('layouts.guest', ['title' => 'Detail Buku'])

@section('content')
<div class="mb-3">
    <a href="{{ route('landing.books') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Buku
    </a>
</div>

<div class="card overflow-hidden">
    <div class="row g-0">
        <div class="col-lg-4">
            <div class="h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(140deg, #e6fffb, #dbeafe); min-height: 420px;">
                @if($book->cover)
                    <img src="{{ asset('storage/'.$book->cover) }}" alt="{{ $book->title }}" class="w-100 h-100" style="object-fit: cover; min-height: 420px;">
                @else
                    <div class="text-center text-secondary">
                        <i class="bi bi-journal-x" style="font-size: 2.25rem;"></i>
                        <div class="fw-semibold mt-2">Cover Tidak Tersedia</div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card-body p-4 p-lg-5">
                <h2 class="fw-bold mb-1">{{ $book->title }}</h2>
                <p class="text-muted mb-4"><i class="bi bi-person me-1"></i>{{ $book->author ?: 'Penulis tidak diketahui' }}</p>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 border h-100 bg-white">
                            <div class="small text-muted">Kode Buku</div>
                            <div class="fw-semibold">{{ $book->code ?: '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 border h-100 bg-white">
                            <div class="small text-muted">Kategori</div>
                            <div class="fw-semibold">{{ $book->category?->name ?: '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 border h-100 bg-white">
                            <div class="small text-muted">Penerbit</div>
                            <div class="fw-semibold">{{ $book->publisher ?: '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 border h-100 bg-white">
                            <div class="small text-muted">Tahun</div>
                            <div class="fw-semibold">{{ $book->year ?: '-' }}</div>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold mb-2">Deskripsi</h6>
                <p class="mb-4 text-secondary">{{ $book->description ?: 'Belum ada deskripsi buku.' }}</p>

                <div class="d-flex flex-wrap gap-2">
                    <span class="badge {{ $book->stock > 0 ? 'text-bg-success' : 'text-bg-danger' }} px-3 py-2">
                        <i class="bi bi-box-seam me-1"></i>Stok {{ $book->stock }}
                    </span>
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-primary"><i class="bi bi-box-arrow-in-right me-1"></i>Login untuk Pinjam</a>
                    @else
                        <a href="{{ route('user.loans.create', ['book_id' => $book->id]) }}" class="btn btn-primary"><i class="bi bi-journal-arrow-up me-1"></i>Pinjam Buku Ini</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <h5 class="fw-bold mb-3"><i class="bi bi-collection me-2"></i>Rekomendasi Buku Serupa</h5>
    <div class="row g-3">
        @forelse($relatedBooks as $item)
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="fw-bold">{{ $item->title }}</h6>
                        <p class="small text-muted mb-2">{{ $item->author ?: '-' }}</p>
                        <a href="{{ route('landing.books.show', $item) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye me-1"></i>Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info mb-0">Belum ada buku serupa.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
