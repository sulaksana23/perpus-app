<!doctype html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Detail Buku</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-slate-50 text-slate-800">
<div class="mx-auto max-w-5xl px-4 py-8">
    <a href="{{ route('landing.books') }}" class="rounded border px-3 py-1.5 text-sm">← Katalog</a>
    <div class="mt-4 rounded-xl border bg-white p-5">
        <h1 class="text-2xl font-bold">{{ $book->title }}</h1>
        <p class="mt-1 text-sm text-slate-600">{{ $book->author }}{{ $book->publisher ? ' • '.$book->publisher : '' }}</p>
        <div class="mt-2 flex flex-wrap gap-2 text-xs"><span class="rounded-full bg-amber-50 px-2 py-0.5 text-amber-700">⭐ {{ number_format((float) $book->avg_rating,1) }}</span><span class="rounded-full bg-emerald-50 px-2 py-0.5 text-emerald-700">Stok {{ $book->stock }}</span><span class="rounded-full bg-slate-100 px-2 py-0.5">{{ $book->category_label }}</span></div>
        <p class="mt-4 text-sm text-slate-700">{{ $book->description ?: 'Belum ada deskripsi buku.' }}</p>
        <div class="mt-4"><a href="{{ route('login') }}" class="rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white">Pinjam Buku</a></div>
    </div>

    <div class="mt-6">
        <h2 class="mb-2 text-lg font-bold">Rating & Ulasan</h2>
        <div class="space-y-2">
            @forelse($book->ratings as $rating)
                <div class="rounded-lg border bg-white px-3 py-2 text-sm"><p class="font-medium">{{ $rating->member->name ?? 'Member' }} • ⭐ {{ $rating->rating }}</p><p class="text-slate-600">{{ $rating->review ?: '-' }}</p></div>
            @empty
                <p class="text-sm text-slate-500">Belum ada rating.</p>
            @endforelse
        </div>
    </div>

    <div class="mt-6">
        <h2 class="mb-2 text-lg font-bold">Buku Terkait</h2>
        <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
            @foreach($relatedBooks as $rel)
                <a href="{{ route('landing.books.show', $rel) }}" class="rounded-lg border bg-white p-3 text-sm"><p class="font-semibold">{{ $rel->title }}</p><p class="text-slate-500">{{ $rel->author }}</p></a>
            @endforeach
        </div>
    </div>
</div>
</body>
</html>
