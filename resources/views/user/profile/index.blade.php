@extends('layouts.user', ['title' => 'Profil Saya'])

@section('content')
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="text-center mb-3">
                    @if($user->photo)
                        <img
                            src="{{ asset('storage/'.$user->photo) }}"
                            alt="Foto profil {{ $user->name }}"
                            class="rounded-circle border object-fit-cover"
                            style="width: 112px; height: 112px;"
                        >
                    @else
                        <div
                            class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold"
                            style="width: 112px; height: 112px; font-size: 2rem; background: linear-gradient(135deg, #0f766e, #14b8a6);"
                        >
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <h5 class="mb-1 text-center">{{ $user->name }}</h5>
                <p class="text-muted text-center mb-3">{{ $user->email }}</p>

                <div class="small">
                    <p class="mb-2"><strong>Role:</strong> {{ $user->role }}</p>
                    <p class="mb-2"><strong>Status Akun:</strong> {{ $user->status_akun }}</p>
                    <p class="mb-0"><strong>Username:</strong> {{ $user->username ?: '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data" class="card">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                    <div>
                        <h5 class="mb-1">Edit Profil</h5>
                        <p class="text-muted mb-0">Perbarui data akun Anda di sini.</p>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control" placeholder="Opsional">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor HP</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control" placeholder="Opsional">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Alamat</label>
                        <textarea name="address" rows="3" class="form-control" placeholder="Opsional">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Foto Profil</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                        <small class="text-muted">Maksimal 2 MB. Kosongkan jika tidak ingin mengganti foto.</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diganti">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                    </div>
                </div>
            </div>

            <div class="card-body border-top d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
