@extends('layouts.app', ['title' => 'Kelola Transaksi'])

@section('content')
<section class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm md:p-5">
    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <div><h1 class="text-xl font-bold">Data Transaksi</h1><p class="mt-1 text-sm text-slate-500">Kelola transaksi, pengembalian, dan denda.</p></div>
        <a href="{{ route('transactions.create') }}" class="rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white">+ Tambah Transaksi</a>
    </div>

    <form method="GET" class="mb-3 grid grid-cols-1 gap-2 md:grid-cols-3">
        <input name="q" value="{{ $search }}" placeholder="Cari kode / anggota / buku" class="rounded border px-3 py-2">
        <select name="status" class="rounded border px-3 py-2"><option value="">Semua status</option>@foreach($statuses as $item)<option value="{{ $item }}" @selected($status===$item)>{{ strtoupper($item) }}</option>@endforeach</select>
        <button class="rounded border px-3 py-2 font-semibold">Filter</button>
    </form>

    <div class="overflow-x-auto rounded-lg border border-slate-200">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-xs text-slate-600"><tr><th class="px-3 py-2 text-left">Kode</th><th class="px-3 py-2 text-left">Anggota</th><th class="px-3 py-2 text-left">Buku</th><th class="px-3 py-2 text-left">Status</th><th class="px-3 py-2 text-left">Denda</th><th class="px-3 py-2 text-left">Aksi</th></tr></thead>
            <tbody class="divide-y">
            @forelse($transactions as $transaction)
                <tr>
                    <td class="px-3 py-2">{{ $transaction->code }}</td>
                    <td class="px-3 py-2">{{ $transaction->member->name ?? '-' }}</td>
                    <td class="px-3 py-2">{{ $transaction->book->title ?? '-' }}</td>
                    <td class="px-3 py-2"><span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold">{{ strtoupper($transaction->status) }}</span></td>
                    <td class="px-3 py-2">Rp {{ number_format((float)$transaction->total_fine, 0, ',', '.') }}</td>
                    <td class="px-3 py-2">
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('transactions.edit', $transaction) }}" class="rounded border px-2 py-1 text-xs">Edit</a>
                            @if(in_array($transaction->status, ['dipinjam','terlambat'], true))
                                <form action="{{ route('transactions.return', $transaction) }}" method="POST" class="flex items-center gap-1">@csrf
                                    <input type="hidden" name="returned_at" value="{{ now()->toDateString() }}">
                                    <select name="book_condition" class="rounded border px-2 py-1 text-xs"><option value="bagus">Bagus</option><option value="rusak_ringan">Rusak Ringan</option><option value="rusak_berat">Rusak Berat</option><option value="hilang">Hilang</option><option value="telat">Telat</option></select>
                                    <button class="rounded bg-emerald-600 px-2 py-1 text-xs text-white">Pengembalian</button>
                                </form>
                            @endif
                            <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?')">@csrf @method('DELETE')<button class="rounded bg-rose-600 px-2 py-1 text-xs text-white">Hapus</button></form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-3 py-6 text-center text-slate-500">Belum ada transaksi.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $transactions->links() }}</div>
</section>
@endsection
