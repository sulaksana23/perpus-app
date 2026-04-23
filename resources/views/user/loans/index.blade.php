@extends('layouts.user', ['title' => 'Riwayat Peminjaman'])

@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('user.loans.create') }}" class="btn btn-primary"><i class="bi bi-journal-plus me-1"></i>Ajukan Peminjaman</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Kode Transaksi</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Jumlah Buku</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($borrowings as $item)
                <tr>
                    <td>{{ $item->transaction_code }}</td>
                    <td>{{ $item->borrow_date?->format('d-m-Y') }}</td>
                    <td>{{ $item->return_date?->format('d-m-Y') }}</td>
                    <td>{{ $item->details->count() }}</td>
                    <td><span class="badge text-bg-secondary">{{ $item->status }}</span></td>
                    <td><a href="{{ route('user.loans.show', $item) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye me-1"></i>Detail</a></td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted">Belum ada riwayat.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $borrowings->links() }}</div>
@endsection
