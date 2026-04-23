@extends('layouts.admin', ['title' => 'Detail Pengajuan'])

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <h5>{{ $borrowing->transaction_code }}</h5>
        <p class="mb-1">User: {{ $borrowing->user?->name }} ({{ $borrowing->user?->email }})</p>
        <p class="mb-1">Tanggal Pinjam: {{ $borrowing->borrow_date?->format('d-m-Y') }}</p>
        <p class="mb-1">Tanggal Kembali: {{ $borrowing->return_date?->format('d-m-Y') }}</p>
        <p class="mb-3">Status: <span class="badge text-bg-secondary">{{ $borrowing->status }}</span></p>

        <div class="d-flex flex-wrap gap-2">
            @if($borrowing->status === 'pending')
                <form method="POST" action="{{ route('admin.loan_requests.approve', $borrowing) }}">
                    @csrf
                    <button class="btn btn-success btn-sm"><i class="bi bi-check2-circle me-1"></i>ACC Pengajuan</button>
                </form>
                <form method="POST" action="{{ route('admin.loan_requests.reject', $borrowing) }}">
                    @csrf
                    <button class="btn btn-danger btn-sm"><i class="bi bi-x-circle me-1"></i>Tolak Pengajuan</button>
                </form>
            @endif

            @if($borrowing->status === 'approved')
                <form method="POST" action="{{ route('admin.loan_requests.mark_borrowed', $borrowing) }}">
                    @csrf
                    <button class="btn btn-primary btn-sm"><i class="bi bi-journal-arrow-up me-1"></i>Set Dipinjam</button>
                </form>
            @endif

            @if($borrowing->status === 'borrowed')
                <form method="POST" action="{{ route('admin.loan_requests.mark_returned', $borrowing) }}">
                    @csrf
                    <button class="btn btn-dark btn-sm"><i class="bi bi-journal-check me-1"></i>Set Dikembalikan</button>
                </form>
            @endif
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">Detail Buku</div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Kode</th><th>Judul</th><th>Qty</th></tr></thead>
            <tbody>
            @foreach($borrowing->details as $detail)
                <tr>
                    <td>{{ $detail->book?->code }}</td>
                    <td>{{ $detail->book?->title }}</td>
                    <td>{{ $detail->qty }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
