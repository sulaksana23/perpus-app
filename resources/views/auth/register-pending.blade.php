@extends('layouts.guest', ['title' => 'Akun Menunggu Persetujuan'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <h5 class="fw-bold mb-2">Registrasi Berhasil</h5>
                <div class="alert alert-warning mb-0">
                    <strong>Akun berhasil didaftarkan, tetapi masih nonaktif.</strong>
                    <div>Silakan hubungi admin agar akun Anda diaktifkan terlebih dahulu.</div>
                </div>
            </div>
        </div>
        <a href="{{ route('login') }}" class="btn btn-primary mt-3">Kembali ke Login</a>
    </div>
</div>
@endsection
