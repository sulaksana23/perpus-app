<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(): View
    {
        return view('admin.transactions.index', [
            'transactions' => Borrowing::query()
                ->with(['user', 'details.book'])
                ->whereIn('status', ['borrowed', 'returned'])
                ->latest()
                ->paginate(10),
        ]);
    }
}
