@extends('layouts.admin', ['title' => 'Dashboard Admin'])

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-4 col-lg-2"><div class="card h-100"><div class="card-body"><small class="text-muted"><i class="bi bi-journal-richtext me-1"></i>Total Buku</small><h4 class="fw-bold mb-0 mt-1">{{ $stats['books'] }}</h4></div></div></div>
    <div class="col-md-4 col-lg-2"><div class="card h-100"><div class="card-body"><small class="text-muted"><i class="bi bi-tags me-1"></i>Kategori</small><h4 class="fw-bold mb-0 mt-1">{{ $stats['categories'] }}</h4></div></div></div>
    <div class="col-md-4 col-lg-2"><div class="card h-100"><div class="card-body"><small class="text-muted"><i class="bi bi-people me-1"></i>User</small><h4 class="fw-bold mb-0 mt-1">{{ $stats['users'] }}</h4></div></div></div>
    <div class="col-md-4 col-lg-3"><div class="card h-100"><div class="card-body"><small class="text-muted"><i class="bi bi-person-lines-fill me-1"></i>Pengajuan Akun</small><h4 class="fw-bold mb-0 mt-1">{{ $stats['pending_accounts'] }}</h4></div></div></div>
    <div class="col-md-4 col-lg-3"><div class="card h-100"><div class="card-body"><small class="text-muted"><i class="bi bi-hourglass-split me-1"></i>Peminjaman Aktif</small><h4 class="fw-bold mb-0 mt-1">{{ $stats['active_loans'] }}</h4></div></div></div>
</div>

<div class="card">
    <div class="card-header"><i class="bi bi-clock-history me-2"></i>Peminjaman Terbaru</div>
    <div class="table-responsive">
        <table class="table table-sm mb-0">
            <thead><tr><th>Kode</th><th>User</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($latestBorrowings as $item)
                <tr>
                    <td>{{ $item->transaction_code }}</td>
                    <td>{{ $item->user?->name }}</td>
                    <td>{{ $item->borrow_date?->format('d-m-Y') }}</td>
                    <td>{{ $item->return_date?->format('d-m-Y') }}</td>
                    <td><span class="badge text-bg-secondary">{{ $item->status }}</span></td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Belum ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
