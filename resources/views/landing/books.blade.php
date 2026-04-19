<!doctype html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Katalog Buku</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-slate-50 text-slate-800">
<div class="mx-auto max-w-7xl px-4 py-8">
    <div class="mb-4 flex items-center justify-between"><h1 class="text-2xl font-bold">Katalog Buku</h1><a href="{{ route('home') }}" class="rounded border px-3 py-1.5 text-sm">Kembali</a></div>
    <form class="mb-4 grid grid-cols-1 gap-2 md:grid-cols-3" method="GET">
        <input name="q" value="{{ $search }}" class="rounded border px-3 py-2" placeholder="Cari buku...">
        <select name="category" class="rounded border px-3 py-2"><option value="">Semua kategori</option>@foreach($categories as $c)<option value="{{ $c->slug }}" @selected($category===$c->slug)>{{ $c->name }}</option>@endforeach</select>
        <button class="rounded bg-blue-600 px-3 py-2 text-white">Filter</button>
    </form>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($books as $book)
            <div class="rounded-xl border bg-white p-3">
                <p class="font-semibold">{{ $book->title }}</p><p class="text-xs text-slate-500">{{ $book->author }}</p>
                <div class="mt-2 text-xs">Rating {{ number_format((float) $book->avg_rating, 1) }} • Stok {{ $book->stock }}</div>
                <div class="mt-3 flex gap-2"><a href="{{ route('landing.books.show',$book) }}" class="rounded border px-2 py-1 text-xs">Detail</a><a href="{{ route('login') }}" class="rounded bg-blue-600 px-2 py-1 text-xs text-white">Pinjam</a></div>
            </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $books->links() }}</div>
</div>
</body>
</html>
