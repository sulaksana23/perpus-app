<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Perpus App' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-[13px] text-slate-800 antialiased md:text-sm">
@auth
    <input id="sidebar-toggle" type="checkbox" class="peer hidden">

    <label for="sidebar-toggle" class="fixed left-3 top-3 z-40 inline-flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-700 shadow-sm md:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 5A.75.75 0 012.75 9h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 9.75zm0 5a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
        </svg>
    </label>

    <label for="sidebar-toggle" class="fixed inset-0 z-20 hidden bg-slate-950/45 peer-checked:block md:hidden"></label>

    <aside class="fixed inset-y-0 left-0 z-30 w-56 -translate-x-full border-r border-slate-200 bg-gradient-to-b from-slate-900 to-slate-950 p-2.5 text-slate-100 shadow-2xl transition-transform duration-200 peer-checked:translate-x-0 md:translate-x-0">
        <div class="rounded-lg border border-white/10 bg-white/5 p-2.5">
            <p class="text-base font-semibold leading-tight">Perpus App</p>
            <p class="mt-0.5 text-[11px] text-slate-300">Sistem Perpustakaan</p>
        </div>

        <nav class="mt-2.5 space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-[13px] font-medium transition {{ request()->routeIs('dashboard') ? 'bg-blue-500 text-white shadow-lg shadow-blue-900/30' : 'text-slate-200 hover:bg-white/10' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.75L12 3l8.25 6.75v9.75a1.5 1.5 0 01-1.5 1.5h-13.5a1.5 1.5 0 01-1.5-1.5V9.75z" />
                </svg>
                Dashboard
            </a>

            @if(auth()->user()?->hasAnyRole(['super-admin', 'admin']))
                <a href="{{ route('members.index') }}" class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-[13px] font-medium transition {{ request()->routeIs('members.*') ? 'bg-blue-500 text-white shadow-lg shadow-blue-900/30' : 'text-slate-200 hover:bg-white/10' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a8.94 8.94 0 00-6-2.72 8.94 8.94 0 00-6 2.72M15 9a3 3 0 11-6 0 3 3 0 016 0zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Anggota
                </a>

                <a href="{{ route('books.index') }}" class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-[13px] font-medium transition {{ request()->routeIs('books.*') ? 'bg-blue-500 text-white shadow-lg shadow-blue-900/30' : 'text-slate-200 hover:bg-white/10' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5A2.25 2.25 0 006.75 21h10.5A2.25 2.25 0 0019.5 18.75V4.5A1.5 1.5 0 0018 3H8.25A3.75 3.75 0 004.5 6.75V19.5z" />
                    </svg>
                    Buku
                </a>

                <a href="{{ route('categories.index') }}" class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-[13px] font-medium transition {{ request()->routeIs('categories.*') ? 'bg-blue-500 text-white shadow-lg shadow-blue-900/30' : 'text-slate-200 hover:bg-white/10' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 4.5h9a3 3 0 013 3v9a3 3 0 01-3 3h-9a3 3 0 01-3-3v-9a3 3 0 013-3z" />
                    </svg>
                    Kategori
                </a>

                <a href="{{ route('transactions.index') }}" class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-[13px] font-medium transition {{ request()->routeIs('transactions.*') ? 'bg-blue-500 text-white shadow-lg shadow-blue-900/30' : 'text-slate-200 hover:bg-white/10' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3h10.5A2.25 2.25 0 0119.5 5.25v13.5A2.25 2.25 0 0117.25 21H6.75A2.25 2.25 0 014.5 18.75V5.25A2.25 2.25 0 016.75 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5h7.5M8.25 12h7.5M8.25 16.5h4.5" />
                    </svg>
                    Transaksi
                </a>

                <a href="{{ route('account-submissions.index') }}" class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-[13px] font-medium transition {{ request()->routeIs('account-submissions.*') ? 'bg-blue-500 text-white shadow-lg shadow-blue-900/30' : 'text-slate-200 hover:bg-white/10' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a3 3 0 100-6 3 3 0 000 6zm0 2.25c-4.14 0-7.5 2.35-7.5 5.25V18h15v-3.75c0-2.9-3.36-5.25-7.5-5.25z" />
                    </svg>
                    Pengajuan Akun
                </a>

                <a href="{{ route('borrow-requests.index') }}" class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-[13px] font-medium transition {{ request()->routeIs('borrow-requests.*') ? 'bg-blue-500 text-white shadow-lg shadow-blue-900/30' : 'text-slate-200 hover:bg-white/10' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0l3-3m-3 3l-3-3M5.25 21h13.5" />
                    </svg>
                    Pengajuan Pinjam
                </a>

                <a href="{{ route('fines.index') }}" class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-[13px] font-medium transition {{ request()->routeIs('fines.*') ? 'bg-blue-500 text-white shadow-lg shadow-blue-900/30' : 'text-slate-200 hover:bg-white/10' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.12-3 2.5S10.343 13 12 13s3 1.12 3 2.5S13.657 18 12 18m0-10V6m0 12v-2m9-4a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Master Denda
                </a>

                <a href="{{ route('users.index') }}" class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-[13px] font-medium transition {{ request()->routeIs('users.*') ? 'bg-blue-500 text-white shadow-lg shadow-blue-900/30' : 'text-slate-200 hover:bg-white/10' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5V4H2v16h5m10 0v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4m10 0H7" />
                    </svg>
                    Admin & User
                </a>
            @else
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-[13px] font-medium transition {{ request()->routeIs('profile.*') ? 'bg-blue-500 text-white shadow-lg shadow-blue-900/30' : 'text-slate-200 hover:bg-white/10' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.118a7.5 7.5 0 0115 0" />
                    </svg>
                    Profil Saya
                </a>

                <a href="{{ route('borrow-requests.create') }}" class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-[13px] font-medium transition {{ request()->routeIs('borrow-requests.create') ? 'bg-blue-500 text-white shadow-lg shadow-blue-900/30' : 'text-slate-200 hover:bg-white/10' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0l3-3m-3 3l-3-3M5.25 21h13.5" />
                    </svg>
                    Ajukan Peminjaman
                </a>
            @endif
        </nav>

        <div class="mt-auto border-t border-white/10 pt-2.5">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-lg border border-white/15 bg-white/10 px-2.5 py-1.5 text-xs font-semibold text-white transition hover:bg-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-7.5a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 006 21h7.5a2.25 2.25 0 002.25-2.25V15M18 12H9m0 0l3-3m-3 3l3 3" />
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="min-h-screen md:pl-56">
        <div class="p-2 md:p-2.5">
            <header class="sticky top-2 z-10 flex h-12 items-center justify-between rounded-xl border border-slate-200 bg-white/95 px-2.5 shadow-sm backdrop-blur md:top-2.5 md:px-3">
                <p class="flex items-center gap-2 text-sm font-semibold text-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $title ?? 'Dashboard' }}
                </p>
                <p class="inline-flex max-w-[48vw] items-center gap-1 truncate rounded-full border border-blue-200 bg-blue-50 px-2 py-0.5 text-[11px] font-medium text-blue-700 md:max-w-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.118a7.5 7.5 0 0115 0" />
                    </svg>
                    {{ auth()->user()->name }}
                </p>
            </header>

            <div class="mx-auto max-w-4xl py-2.5 md:py-3">
                @if(session('success'))
                    <div class="mb-2.5 flex items-start gap-2 rounded-lg border border-emerald-200 bg-emerald-50 px-2.5 py-1.5 text-xs text-emerald-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-2.5 flex items-start gap-2 rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1.5 text-xs text-rose-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.007v.008H12v-.008z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.401 3.003a2.25 2.25 0 015.198 0l6.523 14.119A2.25 2.25 0 0119.12 20.5H4.88a2.25 2.25 0 01-2.002-3.378L9.4 3.003z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-2.5 rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1.5 text-xs text-rose-700">
                        <div class="mb-1 flex items-center gap-2 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M3.98 19h16.04c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L2.248 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Validasi gagal
                        </div>
                        <ul class="list-disc space-y-1 pl-6">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </main>
@else
    <main class="mx-auto max-w-lg px-3 py-6">
        @if(session('success'))
            <div class="mb-3 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="mb-3 rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-sm text-rose-700">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="mb-3 rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-sm text-rose-700">
                <ul class="list-disc pl-6">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
@endauth
</body>
</html>
