<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Perpustakaan' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --bg: #f4f7fb;
            --surface: #ffffff;
            --ink: #1f2937;
            --muted: #64748b;
            --line: #e2e8f0;
            --brand: #0f766e;
            --brand-strong: #115e59;
            --brand-soft: #ccfbf1;
        }

        body {
            font-family: "Plus Jakarta Sans", sans-serif;
            background:
                radial-gradient(circle at 8% -10%, #ccfbf1 0%, transparent 38%),
                radial-gradient(circle at 95% 10%, #dbeafe 0%, transparent 34%),
                var(--bg);
            color: var(--ink);
        }

        .navbar {
            background: rgba(255, 255, 255, 0.92) !important;
            backdrop-filter: blur(10px);
            border-color: var(--line) !important;
        }

        .navbar-brand {
            font-weight: 800;
            color: var(--brand-strong);
            letter-spacing: 0.2px;
        }

        .nav-link {
            color: var(--muted);
            font-weight: 600;
        }

        .nav-link:hover,
        .nav-link:focus {
            color: var(--brand-strong);
        }

        .nav-link.active {
            color: var(--brand-strong);
        }

        .menu-icon {
            font-size: 0.95rem;
            margin-right: 0.35rem;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: 0 10px 35px rgba(15, 23, 42, 0.05);
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            border-color: #d7dee8;
            min-height: 44px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #5eead4;
            box-shadow: 0 0 0 0.2rem rgba(20, 184, 166, 0.15);
        }

        .btn {
            border-radius: 12px;
            font-weight: 600;
            min-height: 42px;
        }

        .btn-sm {
            min-height: 32px;
            border-radius: 10px;
            padding: 0.3rem 0.6rem;
            font-size: 0.82rem;
            line-height: 1.2;
        }

        .btn-primary {
            border-color: var(--brand);
            background: linear-gradient(135deg, var(--brand), #0ea5a4);
        }

        .btn-primary:hover {
            border-color: var(--brand-strong);
            background: linear-gradient(135deg, var(--brand-strong), #0f766e);
        }

        .table {
            --bs-table-bg: transparent;
        }

        .table > :not(caption) > * > * {
            border-color: #edf2f7;
            padding-top: 0.9rem;
            padding-bottom: 0.9rem;
            vertical-align: middle;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white border-bottom">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}"><i class="bi bi-book-half me-1"></i>Perpus App</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto gap-lg-2">
                <li class="nav-item"><a class="nav-link @if(request()->routeIs('home')) active @endif" href="{{ route('home') }}"><i class="bi bi-house-door menu-icon"></i>Home</a></li>
                <li class="nav-item"><a class="nav-link @if(request()->routeIs('landing.books')) active @endif" href="{{ route('landing.books') }}"><i class="bi bi-journal-bookmark menu-icon"></i>Buku</a></li>
                <li class="nav-item"><a class="nav-link @if(request()->routeIs('landing.categories')) active @endif" href="{{ route('landing.categories') }}"><i class="bi bi-tags menu-icon"></i>Kategori</a></li>
                @guest
                    <li class="nav-item"><a class="nav-link @if(request()->routeIs('login')) active @endif" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right menu-icon"></i>Login</a></li>
                    <li class="nav-item"><a class="nav-link @if(request()->routeIs('register')) active @endif" href="{{ route('register') }}"><i class="bi bi-person-plus menu-icon"></i>Register</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 menu-icon"></i>Dashboard</a></li>
                @endguest
            </ul>
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
