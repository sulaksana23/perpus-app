@extends('layouts.admin', ['title' => 'Kelola User'])

@php
    $roleBadge = [
        'admin' => 'bg-sky-100 text-sky-700',
        'user' => 'bg-emerald-100 text-emerald-700',
    ];

    $statusBadge = [
        'active' => 'bg-emerald-100 text-emerald-700',
        'pending' => 'bg-amber-100 text-amber-700',
        'rejected' => 'bg-rose-100 text-rose-700',
    ];
@endphp

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <form method="GET" class="d-flex flex-wrap gap-2">
        <input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Cari nama, email, username">
        <select name="role" class="form-select">
            <option value="">Semua role</option>
            <option value="admin" @selected($role === 'admin')>Admin</option>
            <option value="user" @selected($role === 'user')>User</option>
        </select>
        <button class="btn btn-outline-primary"><i class="bi bi-search me-1"></i>Cari</button>
    </form>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.users.pending') }}" class="btn btn-outline-secondary"><i class="bi bi-person-check me-1"></i>ACC Akun</a>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="bi bi-person-plus me-1"></i>Tambah User</a>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><i class="bi bi-people me-2"></i>Daftar User</span>
        <small class="text-muted">{{ $users->total() }} akun</small>
    </div>
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Kontak</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($users as $item)
                <tr>
                    <td>
                        <div class="fw-semibold">{{ $item->name }}</div>
                        <div class="text-muted small">{{ $item->username ?: 'Tanpa username' }}</div>
                    </td>
                    <td>{{ $item->email }}</td>
                    <td><span class="badge {{ $roleBadge[$item->role] ?? 'bg-secondary' }}">{{ $item->role }}</span></td>
                    <td><span class="badge {{ $statusBadge[$item->status_akun] ?? 'bg-secondary' }}">{{ $item->status_akun }}</span></td>
                    <td>{{ $item->phone ?: '-' }}</td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-1">
                            <a href="{{ route('admin.users.edit', $item) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square me-1"></i>Edit</a>
                            @if(auth()->id() !== $item->id)
                                <form method="POST" action="{{ route('admin.users.destroy', $item) }}" onsubmit="return confirm('Hapus akun ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash me-1"></i>Hapus</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada akun.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection
