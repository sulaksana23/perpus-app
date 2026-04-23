<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin Perpustakaan' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bridge CSS agar view admin lama yang masih pakai class Bootstrap tetap rapi -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --a-bg: #f3f7fb;
            --a-line: #dbe5f0;
            --a-ink: #0f172a;
            --a-muted: #64748b;
            --a-brand: #0f766e;
        }

        body {
            font-family: "Plus Jakarta Sans", sans-serif;
            color: var(--a-ink);
            background:
                radial-gradient(circle at 100% -10%, #dbeafe 0%, transparent 35%),
                radial-gradient(circle at 0% 110%, #ccfbf1 0%, transparent 30%),
                var(--a-bg);
        }

        .card {
            border: 1px solid var(--a-line);
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
        }

        .card-header,
        .card-body {
            padding: 0.75rem 0.9rem;
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #edf2f7;
            font-weight: 700;
        }

        table.table > :not(caption) > * > * {
            border-color: #edf2f7;
            padding-top: 0.55rem;
            padding-bottom: 0.55rem;
            font-size: 0.9rem;
            vertical-align: middle;
        }

        .btn {
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.85rem;
            line-height: 1.1;
        }

        .btn-sm {
            padding: 0.35rem 0.6rem;
        }

        .btn-primary {
            border-color: #0f766e;
            background: linear-gradient(135deg, #0f766e, #0ea5a4);
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            min-height: 38px;
            border-color: #cfd9e4;
            font-size: 0.9rem;
        }

        .form-label {
            margin-bottom: 0.35rem;
            font-size: 0.84rem;
            color: #64748b;
            font-weight: 600;
        }

        .table-responsive {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="min-h-screen lg:flex">
        <input id="admin-sidebar" type="checkbox" class="peer hidden">

        <div class="fixed inset-0 z-30 hidden bg-slate-900/45 peer-checked:block lg:hidden"></div>

        <aside class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full border-r border-slate-700/70 bg-gradient-to-b from-slate-900 to-slate-800 p-3 text-slate-100 shadow-2xl transition-transform peer-checked:translate-x-0 lg:static lg:translate-x-0">
            <div class="mb-3 rounded-xl border border-white/10 bg-white/5 px-3 py-2.5">
                <p class="text-sm font-bold tracking-wide"><i class="bi bi-shield-lock me-2"></i>Admin Panel</p>
                <p class="text-xs text-slate-300">Perpus App</p>
            </div>

            <nav class="space-y-1 text-sm">
                <a class="flex items-center rounded-lg px-2.5 py-2 font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-teal-500/25 text-white' : 'text-slate-200 hover:bg-white/10' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                <a class="flex items-center rounded-lg px-2.5 py-2 font-semibold transition {{ request()->routeIs('admin.books.*') ? 'bg-teal-500/25 text-white' : 'text-slate-200 hover:bg-white/10' }}" href="{{ route('admin.books.index') }}"><i class="bi bi-journal-richtext me-2"></i>Buku</a>
                <a class="flex items-center rounded-lg px-2.5 py-2 font-semibold transition {{ request()->routeIs('admin.categories.*') ? 'bg-teal-500/25 text-white' : 'text-slate-200 hover:bg-white/10' }}" href="{{ route('admin.categories.index') }}"><i class="bi bi-tags me-2"></i>Kategori</a>
                <a class="flex items-center rounded-lg px-2.5 py-2 font-semibold transition {{ request()->routeIs('admin.users.*') ? 'bg-teal-500/25 text-white' : 'text-slate-200 hover:bg-white/10' }}" href="{{ route('admin.users.pending') }}"><i class="bi bi-person-check me-2"></i>ACC Akun</a>
                <a class="flex items-center rounded-lg px-2.5 py-2 font-semibold transition {{ request()->routeIs('admin.loan_requests.*') ? 'bg-teal-500/25 text-white' : 'text-slate-200 hover:bg-white/10' }}" href="{{ route('admin.loan_requests.index') }}"><i class="bi bi-inboxes me-2"></i>Pengajuan Pinjam</a>
                <a class="flex items-center rounded-lg px-2.5 py-2 font-semibold transition {{ request()->routeIs('admin.transactions.*') ? 'bg-teal-500/25 text-white' : 'text-slate-200 hover:bg-white/10' }}" href="{{ route('admin.transactions.index') }}"><i class="bi bi-arrow-left-right me-2"></i>Transaksi</a>
            </nav>
        </aside>

        <main class="min-w-0 flex-1 px-3 py-3 lg:px-4 lg:py-4">
            <div class="mx-auto w-full max-w-7xl">
                <header class="mb-3 flex items-center justify-between rounded-xl border border-slate-200 bg-white px-3 py-2.5 shadow-sm">
                    <div class="flex items-center gap-2">
                        <label for="admin-sidebar" class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg border border-slate-200 text-slate-600 lg:hidden">
                            <i class="bi bi-list text-base"></i>
                        </label>
                        <h1 class="mb-0 text-base font-bold text-slate-800"><i class="bi bi-grid-1x2-fill me-2"></i>{{ $title ?? 'Admin' }}</h1>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-box-arrow-right me-1"></i>Logout</button>
                    </form>
                </header>

                <x-flash-message />
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
