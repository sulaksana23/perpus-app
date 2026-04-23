@extends('layouts.admin', ['title' => 'Transaksi Peminjaman'])

@section('content')
<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Kode</th><th>User</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($transactions as $trx)
                <tr>
                    <td>{{ $trx->transaction_code }}</td>
                    <td>{{ $trx->user?->name }}</td>
                    <td>{{ $trx->borrow_date?->format('d-m-Y') }}</td>
                    <td>{{ $trx->return_date?->format('d-m-Y') }}</td>
                    <td>{{ $trx->status }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Belum ada transaksi.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $transactions->links() }}</div>
@endsection
