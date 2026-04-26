<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard.index', [
            'stats' => [
                'books' => Book::query()->count(),
                'categories' => Category::query()->count(),
                'users' => User::query()->where('role', 'user')->count(),
                'pending_accounts' => User::query()->where('role', 'user')->where('status_akun', 'pending')->count(),
                'active_loans' => Borrowing::query()->whereIn('status', ['approved', 'borrowed'])->count(),
            ],
            'latestBorrowings' => Borrowing::query()
                ->with('user')
                ->withCount('details')
                ->latest()
                ->limit(8)
                ->get(),
        ]);
    }
}
