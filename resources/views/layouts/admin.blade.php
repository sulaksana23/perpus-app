<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin Perpustakaan' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --admin-bg: #f3f7fb;
            --admin-line: #e2e8f0;
            --admin-ink: #1e293b;
            --admin-muted: #64748b;
            --admin-brand: #0ea5a4;
        }

        body {
            font-family: "Plus Jakarta Sans", sans-serif;
            background: var(--admin-bg);
            color: var(--admin-ink);
        }

        .admin-sidebar {
            background: linear-gradient(165deg, #0f172a, #1e293b);
            border-right: 1px solid rgba(148, 163, 184, 0.25);
        }

        .admin-sidebar .nav-link {
            border-radius: 12px;
            color: rgba(226, 232, 240, 0.92);
            font-weight: 600;
            padding: 0.65rem 0.75rem;
        }

        .admin-sidebar .nav-link i {
            margin-right: 0.45rem;
        }

        .admin-sidebar .nav-link:hover {
            background: rgba(148, 163, 184, 0.14);
            color: #fff;
        }

        .admin-sidebar .nav-link.active {
            background: linear-gradient(135deg, rgba(20, 184, 166, 0.5), rgba(14, 165, 233, 0.4));
            color: #fff;
        }

        .admin-panel {
            background:
                radial-gradient(circle at 95% -5%, #dbeafe 0%, transparent 35%),
                radial-gradient(circle at 0% 100%, #ccfbf1 0%, transparent 30%),
                var(--admin-bg);
        }

        .card {
            border: 1px solid var(--admin-line);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        }

        .card-header {
            background: #fff;
            border-bottom-color: #eef2f7;
            font-weight: 700;
        }

        .table > :not(caption) > * > * {
            border-color: #edf2f7;
            padding-top: 0.9rem;
            padding-bottom: 0.9rem;
        }

        .btn {
            border-radius: 12px;
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0ea5a4, #14b8a6);
            border-color: #0ea5a4;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row min-vh-100">
        <aside class="admin-sidebar col-12 col-md-3 col-lg-2 text-white p-3">
            <h5 class="mb-4 fw-bold"><i class="bi bi-shield-lock me-2"></i>Admin Panel</h5>
            <div class="nav flex-column gap-1">
                <a class="nav-link text-white @if(request()->routeIs('admin.dashboard')) active @endif" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
                <a class="nav-link text-white @if(request()->routeIs('admin.books.*')) active @endif" href="{{ route('admin.books.index') }}"><i class="bi bi-journal-richtext"></i>Buku</a>
                <a class="nav-link text-white @if(request()->routeIs('admin.categories.*')) active @endif" href="{{ route('admin.categories.index') }}"><i class="bi bi-tags"></i>Kategori</a>
                <a class="nav-link text-white @if(request()->routeIs('admin.users.*')) active @endif" href="{{ route('admin.users.pending') }}"><i class="bi bi-person-check"></i>ACC Akun</a>
                <a class="nav-link text-white @if(request()->routeIs('admin.loan_requests.*')) active @endif" href="{{ route('admin.loan_requests.index') }}"><i class="bi bi-inboxes"></i>Pengajuan Pinjam</a>
                <a class="nav-link text-white @if(request()->routeIs('admin.transactions.*')) active @endif" href="{{ route('admin.transactions.index') }}"><i class="bi bi-arrow-left-right"></i>Transaksi</a>
            </div>
        </aside>
        <main class="admin-panel col-12 col-md-9 col-lg-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0"><i class="bi bi-grid-1x2-fill me-2"></i>{{ $title ?? 'Admin' }}</h4>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-box-arrow-right me-1"></i>Logout</button>
                </form>
            </div>
            <x-flash-message />
            @yield('content')
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
