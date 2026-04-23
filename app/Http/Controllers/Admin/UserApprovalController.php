<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserApprovalController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('q')->toString());

        $baseQuery = User::query()
            ->where('role', 'user')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($inner) use ($search): void {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            });

        return view('admin.users.pending', [
            'search' => $search,
            'pendingUsers' => (clone $baseQuery)->where('status_akun', 'pending')->latest()->paginate(8, ['*'], 'pending_page')->withQueryString(),
            'activeUsers' => (clone $baseQuery)->where('status_akun', 'active')->latest()->paginate(8, ['*'], 'active_page')->withQueryString(),
            'rejectedUsers' => (clone $baseQuery)->where('status_akun', 'rejected')->latest()->paginate(8, ['*'], 'rejected_page')->withQueryString(),
        ]);
    }

    public function approve(User $user): RedirectResponse
    {
        if ($user->role !== 'user') {
            return back()->with('error', 'Akun ini bukan akun user.');
        }

        $user->update([
            'status_akun' => 'active',
            'is_approved' => true,
            'status' => 'active',
        ]);

        return back()->with('success', 'Akun user berhasil diaktifkan.');
    }

    public function reject(User $user): RedirectResponse
    {
        if ($user->role !== 'user') {
            return back()->with('error', 'Akun ini bukan akun user.');
        }

        $user->update([
            'status_akun' => 'rejected',
            'is_approved' => false,
            'status' => 'inactive',
        ]);

        return back()->with('success', 'Pengajuan akun ditolak.');
    }

    public function deactivate(User $user): RedirectResponse
    {
        if ($user->role !== 'user') {
            return back()->with('error', 'Akun ini bukan akun user.');
        }

        $user->update([
            'status_akun' => 'rejected',
            'is_approved' => false,
            'status' => 'inactive',
        ]);

        return back()->with('success', 'Akun user berhasil dinonaktifkan.');
    }
}
