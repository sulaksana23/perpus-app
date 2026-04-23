@extends('layouts.user', ['title' => 'Dashboard User'])

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card h-100"><div class="card-body"><small class="text-muted"><i class="bi bi-journal-check me-1"></i>Pinjaman Aktif</small><h4 class="fw-bold mt-1 mb-0">{{ $stats['active_loans'] }}</h4></div></div></div>
    <div class="col-md-3"><div class="card h-100"><div class="card-body"><small class="text-muted"><i class="bi bi-send-check me-1"></i>Pengajuan Pending</small><h4 class="fw-bold mt-1 mb-0">{{ $stats['pending_requests'] }}</h4></div></div></div>
    <div class="col-md-3"><div class="card h-100"><div class="card-body"><small class="text-muted"><i class="bi bi-check2-circle me-1"></i>Sudah Kembali</small><h4 class="fw-bold mt-1 mb-0">{{ $stats['returned_books'] }}</h4></div></div></div>
    <div class="col-md-3"><div class="card h-100"><div class="card-body"><small class="text-muted"><i class="bi bi-collection me-1"></i>Buku Tersedia</small><h4 class="fw-bold mt-1 mb-0">{{ $stats['available_books'] }}</h4></div></div></div>
</div>

<div class="card">
    <div class="card-header"><i class="bi bi-clock-history me-2"></i>Riwayat Terbaru</div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Kode</th><th>Jumlah Buku</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($latestBorrowings as $item)
                <tr>
                    <td>{{ $item->transaction_code }}</td>
                    <td>{{ $item->details->count() }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center text-muted">Belum ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
