@extends('layouts.user', ['title' => 'Detail Peminjaman'])

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
            <div>
                <h5 class="fw-bold mb-1"><i class="bi bi-upc-scan me-2"></i>{{ $borrowing->transaction_code }}</h5>
                <p class="mb-1 text-muted">Gunakan kode transaksi ini saat verifikasi ke admin.</p>
            </div>
            <span class="badge text-bg-secondary fs-6">{{ $borrowing->status }}</span>
        </div>

        <hr>
        <div class="row g-2">
            <div class="col-md-6"><strong>Tanggal Pinjam:</strong> {{ $borrowing->borrow_date?->format('d-m-Y') }}</div>
            <div class="col-md-6"><strong>Tanggal Kembali:</strong> {{ $borrowing->return_date?->format('d-m-Y') }}</div>
            <div class="col-md-6"><strong>Diproses Admin:</strong> {{ $borrowing->approved_at ? $borrowing->approved_at->format('d-m-Y H:i') : '-' }}</div>
            <div class="col-md-6"><strong>Tanggal Dikembalikan:</strong> {{ $borrowing->returned_at ? $borrowing->returned_at->format('d-m-Y H:i') : '-' }}</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><i class="bi bi-journals me-2"></i>Daftar Buku Dalam Transaksi</div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Kode Buku</th>
                    <th>Judul</th>
                    <th>Qty</th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrowing->details as $detail)
                    <tr>
                        <td>{{ $detail->book?->code ?: '-' }}</td>
                        <td>{{ $detail->book?->title ?: '-' }}</td>
                        <td>{{ $detail->qty }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">Tidak ada detail buku.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
