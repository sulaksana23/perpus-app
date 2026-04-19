@extends('layouts.app', ['title' => 'Kelola Buku'])

@section('content')
    <section class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm md:p-5">
        <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Data Buku</h1>
                <p class="mt-1 text-sm text-slate-500">CRUD buku sekolah digital.</p>
            </div>
            <a href="{{ route('books.create') }}" class="rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700">+ Tambah Buku</a>
        </div>

        <form class="mb-3 grid grid-cols-1 gap-2 md:grid-cols-3" method="GET">
            <input type="text" name="q" value="{{ $search }}" placeholder="Cari judul / penulis / kode / ISBN" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <select name="category_id" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected((string)$categoryId === (string)$category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            <button class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold">Filter</button>
        </form>

        <div class="overflow-x-auto rounded-lg border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-600">
                    <th class="px-3 py-2">Kode</th>
                    <th class="px-3 py-2">Judul</th>
                    <th class="px-3 py-2">Kategori</th>
                    <th class="px-3 py-2">Stok</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Aksi</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($books as $book)
                    <tr>
                        <td class="px-3 py-2">{{ $book->code }}</td>
                        <td class="px-3 py-2">
                            <p class="font-medium">{{ $book->title }}</p>
                            <p class="text-xs text-slate-500">{{ $book->author }}{{ $book->isbn ? ' • '.$book->isbn : '' }}</p>
                        </td>
                        <td class="px-3 py-2">{{ $book->category_label }}</td>
                        <td class="px-3 py-2">{{ $book->stock }}</td>
                        <td class="px-3 py-2"><span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold">{{ strtoupper($book->status) }}</span></td>
                        <td class="px-3 py-2">
                            <div class="flex gap-2">
                                <a href="{{ route('books.edit', $book) }}" class="rounded border px-2 py-1 text-xs">Edit</a>
                                <form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('Hapus buku ini?')">@csrf @method('DELETE')<button class="rounded bg-rose-600 px-2 py-1 text-xs text-white">Hapus</button></form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-3 py-6 text-center text-slate-500">Belum ada data buku.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $books->links() }}</div>
    </section>
@endsection
