<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku</title>
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
        <div class="absolute -left-28 top-0 h-72 w-72 rounded-full bg-blue-300/30 blur-3xl"></div>
        <div class="absolute right-0 top-24 h-72 w-72 rounded-full bg-indigo-300/25 blur-3xl"></div>
    </div>

    <nav class="border-b border-white/60 bg-white/75 backdrop-blur-xl">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 text-sm font-bold text-white">P</span>
                <span class="text-sm font-bold tracking-tight">Perpus Sekolah Digital</span>
            </a>
            <a href="{{ route('landing.books') }}" class="rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-600">← Katalog</a>
        </div>
    </nav>

    <main class="mx-auto max-w-6xl px-4 py-7 md:py-8">
        <section class="grid gap-4 rounded-3xl border border-slate-200 bg-white/85 p-4 shadow-soft backdrop-blur md:grid-cols-12 md:p-5">
            <div class="md:col-span-4">
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-100">
                    @if($book->cover)
                        <img src="{{ asset('storage/'.$book->cover) }}" alt="{{ $book->title }}" class="h-64 w-full object-cover md:h-80">
                    @else
                        <div class="flex h-64 w-full items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 text-sm font-semibold text-slate-500 md:h-80">No Cover</div>
                    @endif
                </div>
            </div>

            <div class="md:col-span-8">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <p class="inline-flex rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-[11px] font-semibold text-blue-700">Koleksi Perpustakaan</p>
                        <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-slate-900 md:text-3xl">{{ $book->title }}</h1>
                        <p class="mt-1 text-sm text-slate-600">{{ $book->author }}{{ $book->publisher ? ' • '.$book->publisher : '' }}</p>
                    </div>
                    <a href="{{ route('login') }}" class="rounded-xl bg-blue-600 px-4 py-2 text-xs font-bold text-white shadow-soft hover:bg-blue-700">Pinjam Buku</a>
                </div>

                <div class="mt-3 flex flex-wrap gap-2 text-xs">
                    <span class="rounded-full bg-amber-50 px-2.5 py-1 font-semibold text-amber-700">⭐ Rating {{ number_format((float) $book->avg_rating,1) }}</span>
                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 font-semibold text-emerald-700">Stok {{ $book->stock }}</span>
                    <span class="rounded-full bg-slate-100 px-2.5 py-1 font-semibold text-slate-700">{{ $book->category_label }}</span>
                    @if($book->published_year)
                        <span class="rounded-full bg-slate-100 px-2.5 py-1 font-semibold text-slate-700">Terbit {{ $book->published_year }}</span>
                    @endif
                </div>

                <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-3">
                    <h2 class="text-sm font-bold text-slate-900">Deskripsi</h2>
                    <p class="mt-1 text-sm leading-relaxed text-slate-600">{{ $book->description ?: 'Belum ada deskripsi buku.' }}</p>
                </div>

                <div class="mt-3 grid gap-2 sm:grid-cols-3">
                    <div class="rounded-xl border border-slate-200 bg-white px-3 py-2">
                        <p class="text-[11px] text-slate-500">Kode Buku</p>
                        <p class="text-sm font-bold text-slate-800">{{ $book->code ?: '-' }}</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-white px-3 py-2">
                        <p class="text-[11px] text-slate-500">ISBN</p>
                        <p class="text-sm font-bold text-slate-800">{{ $book->isbn ?: '-' }}</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-white px-3 py-2">
                        <p class="text-[11px] text-slate-500">Rak</p>
                        <p class="text-sm font-bold text-slate-800">{{ $book->rack ?: '-' }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-5">
            <h2 class="mb-2 text-base font-bold text-slate-900">Rating & Ulasan</h2>
            <div class="space-y-2">
                @forelse($book->ratings as $rating)
                    <article class="rounded-2xl border border-slate-200 bg-white px-3 py-2.5 shadow-sm">
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-sm font-semibold text-slate-800">{{ $rating->member->name ?? 'Member' }}</p>
                            <span class="rounded-full bg-amber-50 px-2 py-0.5 text-xs font-bold text-amber-700">⭐ {{ $rating->rating }}</span>
                        </div>
                        <p class="mt-1 text-sm text-slate-600">{{ $rating->review ?: '-' }}</p>
                    </article>
                @empty
                    <p class="rounded-xl border border-dashed border-slate-300 bg-white px-3 py-4 text-sm text-slate-500">Belum ada rating untuk buku ini.</p>
                @endforelse
            </div>
        </section>

        <section class="mt-5">
            <h2 class="mb-2 text-base font-bold text-slate-900">Buku Terkait</h2>
            <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                @foreach($relatedBooks as $rel)
                    <a href="{{ route('landing.books.show', $rel) }}" class="group rounded-2xl border border-slate-200 bg-white p-3 shadow-sm transition hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-md">
                        <p class="line-clamp-1 text-sm font-semibold text-slate-900 group-hover:text-blue-700">{{ $rel->title }}</p>
                        <p class="text-xs text-slate-500">{{ $rel->author }}</p>
                    </a>
                @endforeach
            </div>
        </section>
    </main>
</body>
</html>
