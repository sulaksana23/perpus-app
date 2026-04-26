@extends('layouts.guest', ['title' => 'Login'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="alert alert-info border-0 shadow-sm mb-3" style="border-radius: 16px; background: linear-gradient(135deg, #dff7f3, #e8f0ff); color: #0f172a;">
            <div class="fw-semibold mb-1"><i class="bi bi-info-circle me-1"></i>Akun demo</div>
            <div class="small">
                Admin: <strong>admin@example.com</strong> / <strong>password123</strong><br>
                Alternatif admin: <strong>admin@perpus.test</strong> / <strong>password123</strong><br>
                User aktif: <strong>user@perpus.test</strong> / <strong>password123</strong>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="mb-1 fw-bold">Login</h5>
                <p class="text-muted small mb-3">Masuk untuk mengakses fitur peminjaman buku.</p>
                <form method="POST" action="{{ route('login.attempt') }}" class="d-grid gap-3">
                    @csrf
                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', 'admin@example.com') }}" class="form-control" required>
                    </div>
                    <div>
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button class="btn btn-primary" type="submit">Masuk</button>
                </form>
                <small class="text-muted d-block mt-2">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></small>
            </div>
        </div>
    </div>
</div>
@endsection
