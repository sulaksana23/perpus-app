@extends('layouts.admin', ['title' => 'Pengajuan Peminjaman'])

@section('content')
<form method="GET" class="row g-2 mb-3">
    <div class="col-md-4"><input name="code" value="{{ $code }}" class="form-control" placeholder="Cari kode transaksi"></div>
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">Semua Status</option>
            @foreach(['pending', 'approved', 'rejected', 'borrowed', 'returned'] as $s)
                <option value="{{ $s }}" @selected($status === $s)>{{ $s }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2"><button class="btn btn-outline-primary w-100">Filter</button></div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead><tr><th>Kode</th><th>User</th><th>Buku</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($borrowings as $item)
                <tr>
                    <td>{{ $item->transaction_code }}</td>
                    <td>{{ $item->user?->name }}</td>
                    <td>{{ $item->details->count() }} buku</td>
                    <td><span class="badge text-bg-secondary">{{ $item->status }}</span></td>
                    <td class="d-flex flex-wrap gap-1">
                        <a href="{{ route('admin.loan_requests.show', $item) }}" class="btn btn-sm btn-info">Detail</a>
                        @if($item->status === 'pending')
                            <form method="POST" action="{{ route('admin.loan_requests.approve', $item) }}">@csrf<button class="btn btn-sm btn-success">ACC</button></form>
                            <form method="POST" action="{{ route('admin.loan_requests.reject', $item) }}">@csrf<button class="btn btn-sm btn-danger">Tolak</button></form>
                        @endif
                        @if($item->status === 'approved')
                            <form method="POST" action="{{ route('admin.loan_requests.mark_borrowed', $item) }}">@csrf<button class="btn btn-sm btn-primary">Set Dipinjam</button></form>
                        @endif
                        @if($item->status === 'borrowed')
                            <form method="POST" action="{{ route('admin.loan_requests.mark_returned', $item) }}">@csrf<button class="btn btn-sm btn-dark">Set Dikembalikan</button></form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Belum ada data pengajuan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $borrowings->links() }}</div>
@endsection
