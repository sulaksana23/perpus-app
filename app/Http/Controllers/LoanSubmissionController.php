<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\LoanSubmission;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LoanSubmissionController extends Controller
{
    public function create(): View
    {
        return view('loan_submissions.create', [
            'books' => Book::query()->where('stock', '>', 0)->orderBy('title')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'book_id' => ['required', Rule::exists('books', 'id')],
            'notes' => ['nullable', 'string'],
        ]);

        LoanSubmission::create([
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

        $submissions = LoanSubmission::query()
            ->with(['member', 'book', 'reviewer'])
            ->when(in_array($status, ['pending', 'approved', 'rejected'], true), function ($query) use ($status): void {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('loan_submissions.index', compact('submissions', 'status'));
    }

    public function approve(LoanSubmission $loanSubmission): RedirectResponse
    {
        $loanSubmission->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        if ($loanSubmission->book->stock > 0) {
            $loanSubmission->book->decrement('stock');

            Transaction::create([
                'member_id' => $loanSubmission->member_id,
                'book_id' => $loanSubmission->book_id,
                'borrowed_at' => now()->toDateString(),
                'due_at' => now()->addDays(7)->toDateString(),
                'status' => 'dipinjam',
                'notes' => 'Dibuat otomatis dari pengajuan peminjaman #'.$loanSubmission->id,
            ]);
        }

        return back()->with('success', 'Pengajuan peminjaman disetujui. Transaksi dibuat otomatis.');
    }

    public function reject(LoanSubmission $loanSubmission): RedirectResponse
    {
        $loanSubmission->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Pengajuan peminjaman ditolak.');
    }
}
