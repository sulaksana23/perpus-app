@extends('layouts.admin', ['title' => 'Kelola Buku'])

@section('content')
<div class="d-flex justify-content-between mb-3">
    <form method="GET" class="d-flex gap-2">
        <input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Cari buku">
        <button class="btn btn-outline-primary">Cari</button>
    </form>
    <a href="{{ route('admin.books.create') }}" class="btn btn-primary">Tambah Buku</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead><tr><th>Kode</th><th>Judul</th><th>Kategori</th><th>Stok</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($books as $book)
                <tr>
                    <td>{{ $book->code }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->category?->name ?: '-' }}</td>
                    <td>{{ $book->stock }}</td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="{{ route('admin.books.destroy', $book) }}" onsubmit="return confirm('Hapus buku ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Data kosong.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $books->links() }}</div>
@endsection
