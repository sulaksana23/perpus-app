@extends('layouts.admin', ['title' => 'Persetujuan Akun User'])

@section('content')
<form method="GET" class="row g-2 mb-3">
    <div class="col-md-5">
        <input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Cari nama / email user">
    </div>
    <div class="col-md-2">
        <button class="btn btn-outline-primary w-100"><i class="bi bi-search me-1"></i>Cari</button>
    </div>
</form>

<div class="card mb-4">
    <div class="card-header"><i class="bi bi-hourglass-split me-2"></i>Pengajuan Akun Pending</div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Nama</th><th>Email</th><th>Tanggal Daftar</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($pendingUsers as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('d-m-Y H:i') }}</td>
                    <td class="d-flex gap-1">
                        <form method="POST" action="{{ route('admin.users.approve', $user) }}">@csrf<button class="btn btn-sm btn-success"><i class="bi bi-check2-circle me-1"></i>ACC</button></form>
                        <form method="POST" action="{{ route('admin.users.reject', $user) }}">@csrf<button class="btn btn-sm btn-danger"><i class="bi bi-x-circle me-1"></i>Tolak</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted">Tidak ada pengajuan pending.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mb-3">{{ $pendingUsers->links() }}</div>

<div class="card mb-4">
    <div class="card-header"><i class="bi bi-person-check me-2"></i>User Aktif</div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Nama</th><th>Email</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($activeUsers as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge text-bg-success">{{ $user->status_akun }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('admin.users.deactivate', $user) }}" onsubmit="return confirm('Nonaktifkan akun user ini?')">
                            @csrf
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-person-x me-1"></i>Nonaktifkan</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted">Belum ada user aktif.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mb-3">{{ $activeUsers->links() }}</div>

<div class="card">
    <div class="card-header"><i class="bi bi-person-x me-2"></i>Pengajuan Ditolak / Nonaktif</div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Nama</th><th>Email</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($rejectedUsers as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge text-bg-danger">{{ $user->status_akun }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                            @csrf
                            <button class="btn btn-sm btn-outline-success"><i class="bi bi-arrow-repeat me-1"></i>Aktifkan Kembali</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted">Belum ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $rejectedUsers->links() }}</div>
@endsection
