<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LoanRequestController extends Controller
{
    public function index(Request $request): View
    {
        $status = trim($request->string('status')->toString());
        $code = trim($request->string('code')->toString());

        $borrowings = Borrowing::query()
            ->with(['user', 'details.book'])
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->when($code !== '', fn ($query) => $query->where('transaction_code', 'like', "%{$code}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.loan_requests.index', compact('borrowings', 'status', 'code'));
    }

    public function show(Borrowing $borrowing): View
    {
        $borrowing->load(['user', 'details.book', 'approver']);

        return view('admin.loan_requests.show', compact('borrowing'));
    }

    public function approve(Borrowing $borrowing): RedirectResponse
    {
        if ($borrowing->status !== 'pending') {
            return back()->with('error', 'Hanya pengajuan pending yang bisa di-ACC.');
        }

        $borrowing->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Pengajuan peminjaman disetujui.');
    }

    public function reject(Borrowing $borrowing): RedirectResponse
    {
        if (! in_array($borrowing->status, ['pending', 'approved'], true)) {
            return back()->with('error', 'Status saat ini tidak bisa ditolak.');
        }

        $borrowing->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Pengajuan peminjaman ditolak.');
    }

    public function markBorrowed(Borrowing $borrowing): RedirectResponse
    {
        if ($borrowing->status !== 'approved') {
            return back()->with('error', 'Status harus approved sebelum menjadi dipinjam.');
        }

        DB::transaction(function () use ($borrowing): void {
            $borrowing->load('details');

            foreach ($borrowing->details as $detail) {
                $book = Book::query()->lockForUpdate()->findOrFail($detail->book_id);

                if ($book->stock < $detail->qty) {
                    abort(422, 'Stok buku '.$book->title.' tidak cukup.');
                }

                $book->decrement('stock', $detail->qty);
            }

            $borrowing->update([
                'status' => 'borrowed',
                'borrowed_at' => now(),
            ]);
        });

        return back()->with('success', 'Status transaksi berhasil diubah menjadi dipinjam.');
    }

    public function markReturned(Borrowing $borrowing): RedirectResponse
    {
        if ($borrowing->status !== 'borrowed') {
            return back()->with('error', 'Hanya transaksi dipinjam yang bisa dikembalikan.');
        }

        DB::transaction(function () use ($borrowing): void {
            $borrowing->load('details');

            foreach ($borrowing->details as $detail) {
                $book = Book::query()->lockForUpdate()->findOrFail($detail->book_id);
                $book->increment('stock', $detail->qty);
            }

            $borrowing->update([
                'status' => 'returned',
                'returned_at' => now(),
            ]);
        });

        return back()->with('success', 'Buku berhasil dikembalikan dan stok telah diperbarui.');
    }
}
