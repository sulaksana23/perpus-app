<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowRequest;
use App\Models\Fine;
use App\Models\FinePayment;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BorrowRequestController extends Controller
{
    public function create(): View
    {
        return view('borrow_requests.create', [
            'books' => Book::query()->where('stock', '>', 0)->orderBy('title')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'book_id' => ['required', Rule::exists('books', 'id')],
            'notes' => ['nullable', 'string'],
        ]);

        BorrowRequest::create([
            'code' => 'REQ-'.now()->format('YmdHis').'-'.str_pad((string) random_int(1, 999), 3, '0', STR_PAD_LEFT),
            'member_id' => $request->user()->id,
            'book_id' => $validated['book_id'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }

    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $requests = BorrowRequest::query()
            ->with(['member', 'book', 'reviewer'])
            ->when(in_array($status, ['pending', 'approved', 'rejected'], true), fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('borrow_requests.index', compact('requests', 'status'));
    }

    public function approve(BorrowRequest $borrowRequest): RedirectResponse
    {
        if ($borrowRequest->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        if ($borrowRequest->book->stock < 1) {
            return back()->with('error', 'Stok buku habis, pengajuan tidak bisa disetujui.');
        }

        $borrowRequest->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        $borrowRequest->book->decrement('stock');

        Transaction::create([
            'code' => 'TRX-'.now()->format('YmdHis').'-'.str_pad((string) random_int(1, 999), 3, '0', STR_PAD_LEFT),
            'member_id' => $borrowRequest->member_id,
            'book_id' => $borrowRequest->book_id,
            'borrow_request_id' => $borrowRequest->id,
            'borrowed_at' => now()->toDateString(),
            'due_at' => now()->addDays(7)->toDateString(),
            'status' => 'dipinjam',
            'approved_by' => auth()->id(),
            'notes' => 'Disetujui dari pengajuan '.$borrowRequest->code,
        ]);

        return back()->with('success', 'Pengajuan peminjaman disetujui dan transaksi dibuat.');
    }

    public function reject(BorrowRequest $borrowRequest): RedirectResponse
    {
        if ($borrowRequest->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $borrowRequest->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Pengajuan peminjaman ditolak.');
    }

    public function returnBook(Request $request, Transaction $transaction): RedirectResponse
    {
        $validated = $request->validate([
            'returned_at' => ['required', 'date'],
            'book_condition' => ['required', 'in:bagus,rusak_ringan,rusak_berat,hilang,telat'],
            'notes' => ['nullable', 'string'],
        ]);

        $returnedAt = now()->parse($validated['returned_at']);
        $dueAt = $transaction->due_at ? now()->parse($transaction->due_at->toDateString()) : $returnedAt;
        $lateDays = $returnedAt->gt($dueAt) ? $dueAt->diffInDays($returnedAt) : 0;

        $totalFine = 0;

        $lateFine = Fine::query()->where('slug', 'telat-per-hari')->where('is_active', true)->first();
        if ($lateDays > 0 && $lateFine) {
            $lateAmount = $lateFine->type === 'per_day' ? $lateFine->amount * $lateDays : $lateFine->amount;
            $totalFine += $lateAmount;

            FinePayment::create([
                'transaction_id' => $transaction->id,
                'fine_id' => $lateFine->id,
                'member_id' => $transaction->member_id,
                'amount' => $lateAmount,
                'status' => 'unpaid',
                'notes' => 'Denda keterlambatan '.$lateDays.' hari',
            ]);
        }

        $conditionFineMap = [
            'rusak_ringan' => 'buku-rusak-ringan',
            'rusak_berat' => 'buku-rusak-berat',
            'hilang' => 'buku-hilang',
            'telat' => 'telat-per-hari',
        ];

        if (isset($conditionFineMap[$validated['book_condition']])) {
            $fine = Fine::query()->where('slug', $conditionFineMap[$validated['book_condition']])->where('is_active', true)->first();

            if ($fine) {
                $conditionAmount = match ($fine->type) {
                    'percentage' => ($fine->amount / 100) * ($transaction->book->price ?: 0),
                    'full_price' => $transaction->book->price ?: $fine->amount,
                    default => $fine->amount,
                };

                if ($conditionAmount > 0) {
                    $totalFine += $conditionAmount;

                    FinePayment::create([
                        'transaction_id' => $transaction->id,
                        'fine_id' => $fine->id,
                        'member_id' => $transaction->member_id,
                        'amount' => $conditionAmount,
                        'status' => 'unpaid',
                        'notes' => 'Denda kondisi buku: '.$validated['book_condition'],
                    ]);
                }
            }
        }

        $transaction->update([
            'returned_at' => $returnedAt->toDateString(),
            'late_days' => $lateDays,
            'book_condition' => $validated['book_condition'],
            'total_fine' => $totalFine,
            'status' => $lateDays > 0 ? 'terlambat' : 'dikembalikan',
            'notes' => $validated['notes'] ?? $transaction->notes,
        ]);

        if ($validated['book_condition'] !== 'hilang') {
            $transaction->book->increment('stock');
        }

        return back()->with('success', 'Pengembalian berhasil diproses. Total denda: Rp '.number_format($totalFine, 0, ',', '.'));
    }
}
