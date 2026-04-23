<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();

        return view('user.dashboard.index', [
            'stats' => [
                'active_loans' => Borrowing::query()->where('user_id', $userId)->whereIn('status', ['approved', 'borrowed'])->count(),
                'pending_requests' => Borrowing::query()->where('user_id', $userId)->where('status', 'pending')->count(),
                'returned_books' => Borrowing::query()->where('user_id', $userId)->where('status', 'returned')->count(),
                'available_books' => Book::query()->where('stock', '>', 0)->count(),
            ],
            'latestBorrowings' => Borrowing::query()
                ->with('details.book')
                ->where('user_id', $userId)
                ->latest()
                ->limit(8)
                ->get(),
        ]);
    }
}
