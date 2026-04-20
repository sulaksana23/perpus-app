<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Sekolah Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui']
                    },
                    boxShadow: {
                        glow: '0 25px 50px -20px rgba(37, 99, 235, 0.45)',
                        card: '0 14px 35px -20px rgba(15, 23, 42, 0.28)'
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .bg-grid {
            background-image: radial-gradient(rgba(30, 64, 175, .08) 1px, transparent 1px);
            background-size: 16px 16px;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-800">
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -left-20 top-8 h-72 w-72 rounded-full bg-blue-400/25 blur-3xl"></div>
        <div class="absolute right-0 top-0 h-80 w-80 rounded-full bg-indigo-300/20 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/2 h-80 w-80 -translate-x-1/2 rounded-full bg-cyan-200/20 blur-3xl"></div>
        <div class="absolute inset-0 bg-grid"></div>
    </div>

    <header class="sticky top-0 z-30 border-b border-white/40 bg-white/70 backdrop-blur-xl">
        <nav class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3">
            <a href="{{ route('home') }}" class="group flex items-center gap-2">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-600 text-sm font-extrabold text-white shadow-glow">P</span>
                <span class="text-sm font-bold tracking-tight text-slate-900 group-hover:text-blue-700">Perpus Sekolah Digital</span>
            </a>
            <div class="hidden items-center gap-6 text-sm font-semibold text-slate-600 md:flex">
                <a href="#tentang" class="transition hover:text-blue-700">Tentang</a>
                <a href="#katalog" class="transition hover:text-blue-700">Katalog</a>
                <a href="#testimoni" class="transition hover:text-blue-700">Testimoni</a>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('login') }}" class="rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold text-slate-700 transition hover:bg-slate-50">Login</a>
                <a href="{{ route('register') }}" class="rounded-xl bg-slate-900 px-3 py-1.5 text-xs font-bold text-white transition hover:bg-slate-800">Register</a>
            </div>
        </nav>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-8 md:py-10">
        <section class="grid grid-cols-1 gap-4 md:grid-cols-12">
            <div class="md:col-span-7">
                <span class="inline-flex rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-[11px] font-bold text-blue-700">Smart Library Platform</span>
                <h1 class="mt-3 text-4xl font-extrabold leading-tight tracking-tight text-slate-900 md:text-6xl">
                    Perpustakaan
                    <span class="bg-gradient-to-r from-blue-700 to-indigo-600 bg-clip-text text-transparent">Digital Modern</span>
                </h1>
                <p class="mt-3 max-w-2xl text-sm leading-relaxed text-slate-600 md:text-base">Cari buku, cek stok real-time, baca rating, dan ajukan peminjaman online dalam sistem perpustakaan sekolah yang cepat, rapi, dan profesional.</p>

                <form action="{{ route('landing.books') }}" method="GET" class="mt-5 flex flex-col gap-2 sm:flex-row">
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari judul, penulis, kode buku..." class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none ring-blue-500 transition focus:ring-2">
                    <button class="rounded-2xl bg-blue-600 px-5 py-2.5 text-xs font-bold text-white shadow-glow transition hover:bg-blue-700">Search</button>
                </form>
            </div>

            <div class="md:col-span-5">
                <div class="rounded-3xl border border-blue-300/40 bg-gradient-to-br from-blue-600 via-indigo-600 to-blue-800 p-4 text-white shadow-glow">
                    <div class="flex items-center justify-between">
                        <h2 class="text-base font-extrabold">Statistik Perpustakaan</h2>
                        <span class="rounded-full border border-white/20 bg-white/15 px-2 py-0.5 text-[10px] font-bold">Live</span>
                    </div>
                    <div class="mt-3 grid grid-cols-3 gap-2">
                        <div class="rounded-2xl border border-white/20 bg-white/10 p-2.5 text-center">
                            <p class="text-2xl font-extrabold">{{ number_format($stats['books']) }}</p>
                            <p class="text-[11px] text-blue-100">Total Buku</p>
                        </div>
                        <div class="rounded-2xl border border-white/20 bg-white/10 p-2.5 text-center">
                            <p class="text-2xl font-extrabold">{{ number_format($stats['members']) }}</p>
                            <p class="text-[11px] text-blue-100">Anggota</p>
                        </div>
                        <div class="rounded-2xl border border-white/20 bg-white/10 p-2.5 text-center">
                            <p class="text-2xl font-extrabold">{{ number_format($stats['borrowed']) }}</p>
                            <p class="text-[11px] text-blue-100">Dipinjam</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="tentang" class="mt-5 rounded-3xl border border-slate-200 bg-white/85 p-4 shadow-card backdrop-blur">
            <h2 class="text-lg font-extrabold text-slate-900">Tentang Perpustakaan</h2>
            <p class="mt-2 text-sm leading-relaxed text-slate-600">Perpustakaan Sekolah Digital membantu siswa dan guru mengakses koleksi buku secara cepat dan efisien, dengan alur peminjaman yang terintegrasi persetujuan admin.</p>
        </section>

        <section class="mt-5">
            <h2 class="mb-2 text-lg font-extrabold text-slate-900">Daftar Kategori</h2>
            <div class="flex flex-wrap gap-2">
                @forelse($categories as $category)
                    <a href="{{ route('landing.books', ['category' => $category->slug]) }}" class="rounded-full border border-slate-200 bg-white px-3 py-1 text-[11px] font-bold text-slate-600 transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700">{{ $category->name }}</a>
                @empty
                    <p class="text-sm text-slate-500">Kategori belum tersedia.</p>
                @endforelse
            </div>
        </section>

        <section id="katalog" class="mt-6">
            <div class="mb-3 flex items-center justify-between">
                <h2 class="text-xl font-extrabold tracking-tight text-slate-900">Preview Buku Terbaru</h2>
                <a href="{{ route('landing.books') }}" class="text-xs font-bold text-blue-700 hover:underline">Lihat semua</a>
            </div>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
                @forelse($latestBooks as $book)
                    <article class="group rounded-2xl border border-slate-200 bg-white p-3 shadow-card transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="mb-2 h-32 overflow-hidden rounded-xl bg-slate-100">
                            @if($book->cover)
                                <img src="{{ asset('storage/'.$book->cover) }}" alt="{{ $book->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                            @else
                                <div class="flex h-full items-center justify-center text-xs font-semibold text-slate-400">No Cover</div>
                            @endif
                        </div>
                        <p class="line-clamp-1 text-sm font-extrabold text-slate-900">{{ $book->title }}</p>
                        <p class="text-xs text-slate-500">{{ $book->author }}</p>
                        <div class="mt-2 flex items-center justify-between text-xs">
                            <span class="rounded-full bg-amber-50 px-2 py-0.5 font-bold text-amber-700">⭐ {{ number_format((float) $book->avg_rating, 1) }}</span>
                            <span class="rounded-full bg-emerald-50 px-2 py-0.5 font-bold text-emerald-700">Stok {{ $book->stock }}</span>
                        </div>
                        <div class="mt-2.5 flex gap-2">
                            <a href="{{ route('landing.books.show', $book) }}" class="rounded-lg border border-slate-200 px-2 py-1 text-[11px] font-bold text-slate-600">Detail</a>
                            <a href="{{ route('login') }}" class="rounded-lg bg-blue-600 px-2 py-1 text-[11px] font-bold text-white">Pinjam Buku</a>
                        </div>
                    </article>
                @empty
                    <p class="text-sm text-slate-500">Belum ada data buku.</p>
                @endforelse
            </div>
        </section>

        <section class="mt-6">
            <h2 class="mb-3 text-xl font-extrabold tracking-tight text-slate-900">Preview Buku Populer</h2>
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
                @forelse($popularBooks as $book)
                    <article class="rounded-2xl border border-slate-200 bg-white p-3 shadow-card">
                        <p class="line-clamp-1 text-sm font-extrabold text-slate-900">{{ $book->title }}</p>
                        <p class="mt-1 text-xs text-slate-500">Popular score: {{ $book->popular_score }}</p>
                        <p class="mt-1 text-xs text-slate-600">Rating {{ number_format((float) $book->avg_rating, 1) }} • Stok {{ $book->stock }}</p>
                    </article>
                @empty
                    <p class="text-sm text-slate-500">Belum ada data buku populer.</p>
                @endforelse
            </div>
        </section>

        <section id="testimoni" class="mt-6">
            <h2 class="mb-3 text-xl font-extrabold tracking-tight text-slate-900">Testimoni</h2>
            <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-card">
                    <p class="text-sm text-slate-700">"Aplikasi ini bikin cari buku jadi cepat dan gampang."</p>
                    <p class="mt-2 text-xs font-extrabold text-slate-800">- Siswa Kelas 11</p>
                </article>
                <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-card">
                    <p class="text-sm text-slate-700">"Proses pinjam lebih rapi karena ada approval admin."</p>
                    <p class="mt-2 text-xs font-extrabold text-slate-800">- Petugas Perpustakaan</p>
                </article>
                <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-card">
                    <p class="text-sm text-slate-700">"Dashboard admin lengkap dan cocok buat presentasi UKK."</p>
                    <p class="mt-2 text-xs font-extrabold text-slate-800">- Guru RPL</p>
                </article>
            </div>
        </section>
    </main>

    <footer class="border-t border-white/60 bg-white/80 backdrop-blur-xl">
        <div class="mx-auto grid max-w-6xl grid-cols-1 gap-3 px-4 py-5 text-sm text-slate-600 md:grid-cols-3">
            <div>
                <p class="font-extrabold text-slate-900">Perpus Sekolah Digital</p>
                <p class="mt-1 text-xs">Sistem perpustakaan modern berbasis web.</p>
            </div>
            <div>
                <p class="font-extrabold text-slate-900">Menu</p>
                <p class="mt-1 text-xs">Landing • Katalog • Login • Register</p>
            </div>
            <div>
                <p class="font-extrabold text-slate-900">Kontak</p>
                <p class="mt-1 text-xs">Jl. Pendidikan No. 1 • +62 8xx xxxx xxxx</p>
            </div>
        </div>
    </footer>
</body>
</html>
