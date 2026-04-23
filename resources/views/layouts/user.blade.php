<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'User Perpustakaan' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --user-bg: #f4f7fb;
            --user-surface: #ffffff;
            --user-line: #e2e8f0;
            --user-brand: #0f766e;
            --user-brand-2: #0ea5a4;
            --user-muted: #64748b;
        }

        body {
            font-family: "Plus Jakarta Sans", sans-serif;
            background:
                radial-gradient(circle at 100% -10%, #dbeafe 0%, transparent 38%),
                radial-gradient(circle at 0% 110%, #ccfbf1 0%, transparent 35%),
                var(--user-bg);
        }

        .navbar {
            background: rgba(255, 255, 255, 0.92) !important;
            backdrop-filter: blur(10px);
            border-color: var(--user-line) !important;
        }

        .navbar-brand {
            color: #0f172a;
            font-weight: 800;
        }

        .nav-link {
            color: var(--user-muted);
            font-weight: 600;
        }

        .nav-link:hover {
            color: var(--user-brand);
        }

        .nav-link.active {
            color: var(--user-brand);
        }

        .nav-link i {
            margin-right: 0.35rem;
        }

        .card {
            background: var(--user-surface);
            border-radius: 16px;
            border: 1px solid var(--user-line);
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        }

        .card-header {
            background: #fff;
            border-bottom-color: #edf2f7;
            font-weight: 700;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            min-height: 44px;
            border-color: #d8e0ea;
        }

        .btn {
            border-radius: 12px;
            font-weight: 600;
        }

        .btn-primary {
            border-color: var(--user-brand);
            background: linear-gradient(135deg, var(--user-brand), var(--user-brand-2));
        }

        .table > :not(caption) > * > * {
            border-color: #edf2f7;
            padding-top: 0.9rem;
            padding-bottom: 0.9rem;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white border-bottom">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('user.dashboard') }}"><i class="bi bi-book me-1"></i>Perpus User</a>
        <div class="navbar-nav ms-auto d-flex align-items-center gap-2">
            <a class="nav-link @if(request()->routeIs('user.books.*')) active @endif" href="{{ route('user.books.index') }}"><i class="bi bi-journal"></i>Buku</a>
            <a class="nav-link @if(request()->routeIs('user.loans.*')) active @endif" href="{{ route('user.loans.index') }}"><i class="bi bi-clock-history"></i>Riwayat Pinjam</a>
            <a class="nav-link @if(request()->routeIs('user.profile.*')) active @endif" href="{{ route('user.profile.index') }}"><i class="bi bi-person-circle"></i>Profil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-sm btn-outline-danger" type="submit"><i class="bi bi-box-arrow-right me-1"></i>Logout</button>
            </form>
        </div>
    </div>
</nav>

<main class="container py-4">
    <x-flash-message />
    @yield('content')
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
