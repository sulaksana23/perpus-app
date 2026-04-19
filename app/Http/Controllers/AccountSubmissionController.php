<?php

namespace App\Http\Controllers;

use App\Models\AccountSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountSubmissionController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $submissions = AccountSubmission::query()
            ->with(['user', 'reviewer'])
            ->when(in_array($status, ['pending', 'approved', 'rejected'], true), function ($query) use ($status): void {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('account_submissions.index', compact('submissions', 'status'));
    }

    public function approve(AccountSubmission $accountSubmission): RedirectResponse
    {
        $accountSubmission->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        if ($accountSubmission->user) {
            $accountSubmission->user->update(['is_approved' => true, 'status' => 'active']);
            $accountSubmission->user->syncRoles(['member']);
        }

        return back()->with('success', 'Pengajuan akun disetujui.');
    }

    public function reject(AccountSubmission $accountSubmission): RedirectResponse
    {
        $accountSubmission->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        if ($accountSubmission->user) {
            $accountSubmission->user->update(['is_approved' => false, 'status' => 'rejected']);
        }

        return back()->with('success', 'Pengajuan akun ditolak.');
    }
}
