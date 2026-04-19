<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowRequest;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('q')->toString();
        $status = $request->string('status')->toString();

        $transactions = Transaction::query()
            ->with(['member', 'book'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($inner) use ($search): void {
                    $inner->where('code', 'like', "%{$search}%")
                        ->orWhereHas('member', fn ($q) => $q->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('book', fn ($q) => $q->where('title', 'like', "%{$search}%"));
                });
            })
            ->when($status !== '', fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('transactions.index', [
            'transactions' => $transactions,
            'statuses' => $this->statusOptions(),
            'search' => $search,
            'status' => $status,
        ]);
    }

    public function create(): View
    {
        return view('transactions.create', [
            'members' => $this->memberOptions(),
            'books' => Book::query()->orderBy('title')->get(),
            'requests' => BorrowRequest::query()->where('status', 'approved')->orderByDesc('id')->limit(100)->get(),
            'statuses' => $this->statusOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePayload($request);
        $validated['code'] = $validated['code'] ?? ('TRX-'.now()->format('YmdHis').'-'.str_pad((string) random_int(1, 999), 3, '0', STR_PAD_LEFT));

        Transaction::create($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(Transaction $transaction): View
    {
        return view('transactions.edit', [
            'transaction' => $transaction,
            'members' => $this->memberOptions(),
            'books' => Book::query()->orderBy('title')->get(),
            'requests' => BorrowRequest::query()->where('status', 'approved')->orderByDesc('id')->limit(100)->get(),
            'statuses' => $this->statusOptions(),
        ]);
    }

    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        $validated = $this->validatePayload($request, $transaction);

        $transaction->update($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction): RedirectResponse
    {
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatePayload(Request $request, ?Transaction $transaction = null): array
    {
        return $request->validate([
            'code' => ['nullable', 'string', 'max:100', Rule::unique('transactions', 'code')->ignore($transaction?->id)],
            'member_id' => ['required', Rule::exists('users', 'id')],
            'book_id' => ['required', Rule::exists('books', 'id')],
            'borrow_request_id' => ['nullable', Rule::exists('borrow_requests', 'id')],
            'borrowed_at' => ['required', 'date'],
            'due_at' => ['required', 'date', 'after_or_equal:borrowed_at'],
            'extended_until' => ['nullable', 'date', 'after_or_equal:due_at'],
            'returned_at' => ['nullable', 'date', 'after_or_equal:borrowed_at'],
            'status' => ['required', Rule::in($this->statusOptions())],
            'book_condition' => ['nullable', Rule::in(['bagus', 'rusak_ringan', 'rusak_berat', 'hilang', 'telat'])],
            'notes' => ['nullable', 'string'],
        ]);
    }

    /**
     * @return array<int, string>
     */
    private function statusOptions(): array
    {
        return ['pending', 'dipinjam', 'dikembalikan', 'ditolak', 'terlambat'];
    }

    private function memberOptions()
    {
        return User::query()->role('member')->orderBy('name')->get();
    }
}
