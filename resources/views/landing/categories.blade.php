@extends('layouts.guest', ['title' => 'Kategori Buku'])

@section('content')
<h1 class="h4 mb-3">Kategori Buku</h1>
<div class="row g-3">
    @forelse($categories as $category)
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6>{{ $category->name }}</h6>
                    <p class="small text-muted">{{ $category->description ?: 'Tidak ada deskripsi.' }}</p>
                    <span class="badge text-bg-primary">{{ $category->books_count }} buku</span>
                    <div class="mt-3">
                        <a href="{{ route('landing.books', ['category_id' => $category->id]) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-funnel me-1"></i>Lihat Buku
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12"><div class="alert alert-info">Belum ada kategori.</div></div>
    @endforelse
</div>
@endsection
