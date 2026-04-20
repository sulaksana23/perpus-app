<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui']
                    },
                    boxShadow: {
                        soft: '0 20px 45px -20px rgba(15, 23, 42, 0.32)'
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -left-24 top-0 h-72 w-72 rounded-full bg-blue-300/30 blur-3xl"></div>
        <div class="absolute right-0 top-24 h-72 w-72 rounded-full bg-cyan-200/30 blur-3xl"></div>
    </div>

    <nav class="border-b border-white/60 bg-white/75 backdrop-blur-xl">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 text-sm font-bold text-white">P</span>
                <span class="text-sm font-bold tracking-tight">Perpus Sekolah Digital</span>
            </a>
            <a href="{{ route('home') }}" class="rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-600">Beranda</a>
        </div>
    </nav>

    <main class="mx-auto max-w-6xl px-4 py-6">
        <div class="mb-3 flex items-center justify-between">
            <h1 class="text-xl font-extrabold tracking-tight text-slate-900">Katalog Buku</h1>
            <span class="rounded-full bg-blue-50 px-3 py-1 text-[11px] font-semibold text-blue-700">{{ $books->total() }} koleksi ditemukan</span>
        </div>

        <form class="mb-4 grid grid-cols-1 gap-2 rounded-2xl border border-slate-200 bg-white p-3 shadow-sm md:grid-cols-3" method="GET">
            <input name="q" value="{{ $search }}" class="rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none ring-blue-500 focus:ring-2" placeholder="Cari judul, penulis, kode...">
            <select name="category" class="rounded-xl border border-slate-200 px-3 py-2 text-sm"><option value="">Semua kategori</option>@foreach($categories as $c)<option value="{{ $c->slug }}" @selected($category===$c->slug)>{{ $c->name }}</option>@endforeach</select>
            <button class="rounded-xl bg-blue-600 px-3 py-2 text-xs font-semibold text-white shadow-soft">Filter</button>
        </form>

        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($books as $book)
                <article class="group rounded-2xl border border-slate-200 bg-white p-3 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="mb-2 h-28 overflow-hidden rounded-xl bg-slate-100">
                        @if($book->cover)
                            <img src="{{ asset('storage/'.$book->cover) }}" alt="{{ $book->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                        @else
                            <div class="flex h-full items-center justify-center text-xs text-slate-400">No Cover</div>
                        @endif
                    </div>
                    <p class="line-clamp-1 text-sm font-semibold text-slate-900">{{ $book->title }}</p>
                    <p class="text-xs text-slate-500">{{ $book->author }}</p>
                    <div class="mt-2 flex items-center justify-between text-xs">
                        <span class="rounded-full bg-amber-50 px-2 py-0.5 font-semibold text-amber-700">⭐ {{ number_format((float) $book->avg_rating, 1) }}</span>
                        <span class="rounded-full bg-emerald-50 px-2 py-0.5 font-semibold text-emerald-700">Stok {{ $book->stock }}</span>
                    </div>
                    <div class="mt-2.5 flex gap-2">
                        <a href="{{ route('landing.books.show',$book) }}" class="rounded-lg border border-slate-200 px-2 py-1 text-[11px] font-semibold text-slate-600">Detail</a>
                        <a href="{{ route('login') }}" class="rounded-lg bg-blue-600 px-2 py-1 text-[11px] font-semibold text-white">Pinjam</a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-4">{{ $books->links() }}</div>
    </main>
</body>
</html>
