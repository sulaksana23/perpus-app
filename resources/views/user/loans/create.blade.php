@extends('layouts.user', ['title' => 'Ajukan Peminjaman'])

@section('content')
<div class="card card-body mb-3">
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Kode Transaksi (otomatis)</label>
            <input type="text" class="form-control" value="{{ $previewTransactionCode }}" readonly>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tanggal Pinjam (otomatis)</label>
            <input type="date" class="form-control" value="{{ $autoBorrowDate }}" readonly>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tanggal Kembali (otomatis +7 hari)</label>
            <input type="date" class="form-control" value="{{ $autoReturnDate }}" readonly>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('user.loans.store') }}" class="card card-body">
    @csrf
    <h6 class="mb-3">Pilih Buku yang Ingin Dipinjam</h6>
    <div class="row g-2 mb-3">
        @foreach($availableBooks as $book)
            <div class="col-md-6">
                <label class="border rounded p-2 w-100 d-flex align-items-start gap-2">
                    <input type="checkbox" name="book_ids[]" value="{{ $book->id }}" class="form-check-input mt-1"
                        @checked((int)$selectedBookId === $book->id || in_array($book->id, old('book_ids', []), true))>
                    <span>
                        <strong>{{ $book->title }}</strong><br>
                        <small class="text-muted">Kode: {{ $book->code }} | Stok: {{ $book->stock }}</small>
                    </span>
                </label>
            </div>
        @endforeach
    </div>
    <div class="mb-3">
        <label class="form-label">Catatan</label>
        <textarea name="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
    </div>
    <button class="btn btn-primary">Kirim Pengajuan</button>
</form>
@endsection
