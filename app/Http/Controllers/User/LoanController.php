<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Services\TransactionCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoanController extends Controller
{
    public function __construct(private readonly TransactionCodeService $transactionCodeService)
    {
    }

    public function index(): View
    {
        return view('user.loans.index', [
            'borrowings' => Borrowing::query()
                ->with('details.book')
                ->where('user_id', auth()->id())
                ->latest()
                ->paginate(10),
        ]);
    }

    public function show(Borrowing $borrowing): View
    {
        abort_if($borrowing->user_id !== auth()->id(), 403);

        $borrowing->load('details.book');

        return view('user.loans.show', compact('borrowing'));
    }

    public function create(Request $request): View
    {
        $selectedBookId = $request->integer('book_id');

        return view('user.loans.create', [
            'availableBooks' => Book::query()->where('stock', '>', 0)->orderBy('title')->get(),
            'selectedBookId' => $selectedBookId,
            'autoBorrowDate' => now()->toDateString(),
            'autoReturnDate' => now()->addDays(7)->toDateString(),
            'previewTransactionCode' => $this->transactionCodeService->generate(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'book_ids' => ['required', 'array', 'min:1'],
            'book_ids.*' => ['integer', 'exists:books,id'],
            'notes' => ['nullable', 'string'],
        ]);

        $bookIds = collect($validated['book_ids'])->unique()->values();
        $books = Book::query()->whereIn('id', $bookIds)->get()->keyBy('id');

        foreach ($bookIds as $bookId) {
            $book = $books->get($bookId);
            if (! $book || $book->stock < 1) {
                throw ValidationException::withMessages([
                    'book_ids' => 'Ada buku yang stoknya habis. Silakan pilih buku lain.',
                ]);
            }
        }

        $requestedTitles = $books->pluck('title')->values();

        if ($requestedTitles->count() !== $requestedTitles->unique()->count()) {
            throw ValidationException::withMessages([
                'book_ids' => 'Dalam 1 pengajuan, Anda tidak boleh memilih judul buku yang sama.',
            ]);
        }

        $activeTitles = BorrowingDetail::query()
            ->join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')
            ->join('books', 'books.id', '=', 'borrowing_details.book_id')
            ->where('borrowings.user_id', auth()->id())
            ->whereIn('borrowings.status', ['pending', 'approved', 'borrowed'])
            ->pluck('books.title')
            ->unique();

        $hasDuplicateTitle = $requestedTitles->intersect($activeTitles)->isNotEmpty();

        if ($hasDuplicateTitle) {
            throw ValidationException::withMessages([
                'book_ids' => 'Anda masih memiliki pinjaman aktif dengan judul yang sama.',
            ]);
        }

        $transactionCode = DB::transaction(function () use ($bookIds, $validated): string {
            // Kode transaksi dan tanggal dikunci otomatis dari backend agar user tidak bisa mengubah.
            $code = $this->transactionCodeService->generate();
            while (Borrowing::query()->where('transaction_code', $code)->exists()) {
                $code = $this->transactionCodeService->generate();
            }

            $borrowing = Borrowing::query()->create([
                'transaction_code' => $code,
                'user_id' => auth()->id(),
                'borrow_date' => now()->toDateString(),
                'return_date' => now()->addDays(7)->toDateString(),
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($bookIds as $bookId) {
                BorrowingDetail::query()->create([
                    'borrowing_id' => $borrowing->id,
                    'book_id' => $bookId,
                    'qty' => 1,
                ]);
            }

            return $borrowing->transaction_code;
        });

        return redirect()
            ->route('user.loans.index')
            ->with('success', "Pengajuan peminjaman berhasil dikirim. Kode transaksi Anda: {$transactionCode}");
    }
}
