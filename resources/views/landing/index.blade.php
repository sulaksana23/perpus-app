<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Sekolah Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800">
    <nav class="sticky top-0 z-20 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3">
            <div class="flex items-center gap-2"><div class="h-8 w-8 rounded-lg bg-blue-600"></div><span class="font-bold">Perpus Sekolah Digital</span></div>
            <div class="hidden gap-6 text-sm md:flex"><a href="#tentang">Tentang</a><a href="#katalog">Katalog</a><a href="#testimoni">Testimoni</a></div>
            <div class="flex gap-2"><a href="{{ route('login') }}" class="rounded-lg border px-3 py-1.5 text-sm">Login</a><a href="{{ route('register') }}" class="rounded-lg bg-blue-600 px-3 py-1.5 text-sm text-white">Register</a></div>
        </div>
    </nav>

    <section class="mx-auto grid max-w-7xl grid-cols-1 gap-6 px-4 py-10 md:grid-cols-2 md:py-14">
        <div>
            <p class="mb-2 inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">Perpustakaan Modern Sekolah</p>
            <h1 class="text-4xl font-extrabold leading-tight md:text-5xl">Belajar Lebih Mudah dengan <span class="text-blue-600">Perpustakaan Digital</span></h1>
            <p class="mt-4 text-slate-600">Cari buku, lihat rating, cek stok, dan ajukan peminjaman secara online dengan tampilan modern, rapi, dan responsif.</p>
            <form action="{{ route('landing.books') }}" method="GET" class="mt-5 flex gap-2">
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari judul buku, penulis, kode..." class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                <button class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white">Search</button>
            </form>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 p-6 text-white shadow-lg">
            <h2 class="text-xl font-bold">Statistik Perpustakaan</h2>
            <div class="mt-4 grid grid-cols-3 gap-3 text-center">
                <div class="rounded-xl bg-white/10 p-3"><p class="text-2xl font-bold">{{ number_format($stats['books']) }}</p><p class="text-xs">Total Buku</p></div>
                <div class="rounded-xl bg-white/10 p-3"><p class="text-2xl font-bold">{{ number_format($stats['members']) }}</p><p class="text-xs">Anggota</p></div>
                <div class="rounded-xl bg-white/10 p-3"><p class="text-2xl font-bold">{{ number_format($stats['borrowed']) }}</p><p class="text-xs">Dipinjam</p></div>
            </div>
        </div>
    </section>

    <section id="tentang" class="mx-auto max-w-7xl px-4 pb-8">
        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <h2 class="text-2xl font-bold">Tentang Perpustakaan</h2>
            <p class="mt-2 text-sm text-slate-600">Perpustakaan Sekolah Digital membantu siswa dan guru mengakses koleksi buku secara cepat, efisien, dan terintegrasi dengan proses peminjaman berbasis persetujuan admin.</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 pb-8">
        <h2 class="mb-3 text-xl font-bold">Daftar Kategori</h2>
        <div class="flex flex-wrap gap-2">
            @forelse($categories as $category)
                <a href="{{ route('landing.books', ['category' => $category->slug]) }}" class="rounded-full border border-slate-300 bg-white px-3 py-1 text-sm">{{ $category->name }}</a>
            @empty
                <p class="text-sm text-slate-500">Kategori belum tersedia.</p>
            @endforelse
        </div>
    </section>

    <section id="katalog" class="mx-auto max-w-7xl px-4 pb-8">
        <div class="mb-3 flex items-center justify-between"><h2 class="text-xl font-bold">Preview Buku Terbaru</h2><a href="{{ route('landing.books') }}" class="text-sm font-semibold text-blue-600">Lihat semua</a></div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @forelse($latestBooks as $book)
                <div class="rounded-xl border border-slate-200 bg-white p-3">
                    <div class="mb-2 h-36 rounded-lg bg-slate-100 bg-cover bg-center" style="background-image:url('{{ $book->cover ? asset('storage/'.$book->cover) : '' }}')"></div>
                    <p class="line-clamp-1 font-semibold">{{ $book->title }}</p>
                    <p class="text-xs text-slate-500">{{ $book->author }}</p>
                    <div class="mt-2 flex items-center justify-between text-xs"><span class="rounded-full bg-amber-50 px-2 py-0.5 text-amber-700">⭐ {{ number_format((float) $book->avg_rating, 1) }}</span><span class="rounded-full bg-emerald-50 px-2 py-0.5 text-emerald-700">Stok {{ $book->stock }}</span></div>
                    <div class="mt-3 flex gap-2"><a href="{{ route('landing.books.show', $book) }}" class="rounded-lg border px-2 py-1 text-xs">Detail</a><a href="{{ route('login') }}" class="rounded-lg bg-blue-600 px-2 py-1 text-xs text-white">Pinjam Buku</a></div>
                </div>
            @empty
                <p class="text-sm text-slate-500">Belum ada data buku.</p>
            @endforelse
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 pb-8">
        <h2 class="mb-3 text-xl font-bold">Preview Buku Populer</h2>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @forelse($popularBooks as $book)
                <div class="rounded-xl border border-slate-200 bg-white p-3">
                    <p class="line-clamp-1 font-semibold">{{ $book->title }}</p>
                    <p class="text-xs text-slate-500">Popular score: {{ $book->popular_score }}</p>
                    <div class="mt-2 text-xs text-slate-600">Rating {{ number_format((float) $book->avg_rating, 1) }} • Stok {{ $book->stock }}</div>
                </div>
            @empty
                <p class="text-sm text-slate-500">Belum ada data buku populer.</p>
            @endforelse
        </div>
    </section>

    <section id="testimoni" class="mx-auto max-w-7xl px-4 pb-10">
        <h2 class="mb-3 text-xl font-bold">Testimoni</h2>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="rounded-xl border bg-white p-4 text-sm">"Aplikasi ini bikin cari buku jadi cepat dan gampang."<p class="mt-2 font-semibold">- Siswa Kelas 11</p></div>
            <div class="rounded-xl border bg-white p-4 text-sm">"Proses pinjam lebih rapi karena ada approval admin."<p class="mt-2 font-semibold">- Petugas Perpustakaan</p></div>
            <div class="rounded-xl border bg-white p-4 text-sm">"Dashboard admin lengkap dan cocok buat presentasi UKK."<p class="mt-2 font-semibold">- Guru RPL</p></div>
        </div>
    </section>

    <footer class="border-t bg-white">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-4 px-4 py-6 text-sm text-slate-600 md:grid-cols-3">
            <div><p class="font-semibold text-slate-800">Perpus Sekolah Digital</p><p class="mt-1">Sistem perpustakaan modern berbasis web.</p></div>
            <div><p class="font-semibold text-slate-800">Menu</p><p class="mt-1">Landing • Katalog • Login • Register</p></div>
            <div><p class="font-semibold text-slate-800">Kontak</p><p class="mt-1">Jl. Pendidikan No. 1 • +62 8xx xxxx xxxx</p></div>
        </div>
    </footer>
</body>
</html>
