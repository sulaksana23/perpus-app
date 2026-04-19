<?php

namespace App\Http\Controllers;

use App\Models\AccountSubmission;
use App\Models\Book;
use App\Models\BorrowRequest;
use App\Models\FinePayment;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Email atau password tidak valid.'])
                ->onlyInput('email');
        }

        $user = $request->user();
        $isAdmin = $user?->hasRole('admin') || $user?->role === 'admin';

        if ($user && ! $isAdmin && (! $user->is_approved || $user->status !== 'active')) {
            Auth::logout();

            return back()
                ->withErrors(['email' => 'Akun Anda masih menunggu persetujuan admin.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'phone' => ['required', 'string', 'max:25'],
            'address' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'notes' => ['nullable', 'string'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('profiles', 'public');
        }

        DB::transaction(function () use ($validated, $photoPath): void {

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'username' => $validated['username'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'photo' => $photoPath,
                'password' => $validated['password'],
                'role' => 'member',
                'is_approved' => false,
                'status' => 'pending',
            ]);
            $user->assignRole(Role::findOrCreate('member', 'web'));

            AccountSubmission::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'notes' => $validated['notes'] ?? null,
                'status' => 'pending',
            ]);
        });

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Tunggu persetujuan admin untuk bisa login.');
    }

    public function dashboard(Request $request): View
    {
        $user = $request->user();
        $role = $user?->getRoleNames()->implode(', ');
        $isAdmin = $user?->hasRole('admin') || $user?->role === 'admin';

        $dashboardData = [];

        if ($isAdmin) {
            $monthPoints = collect(range(5, 0))->map(fn (int $i) => now()->subMonths($i));
            $firstMonthStart = $monthPoints->first()?->copy()->startOfMonth();

            $monthlyTransactionsRaw = Transaction::query()
                ->selectRaw("DATE_FORMAT(borrowed_at, '%Y-%m') as month_key, COUNT(*) as total")
                ->whereDate('borrowed_at', '>=', $firstMonthStart)
                ->groupBy('month_key')
                ->pluck('total', 'month_key');

            $monthlyTransactionLabels = $monthPoints
                ->map(fn ($point) => $point->format('M Y'))
                ->values();

            $monthlyTransactionSeries = $monthPoints
                ->map(fn ($point) => (int) ($monthlyTransactionsRaw[$point->format('Y-m')] ?? 0))
                ->values();

            $transactionStatusRaw = Transaction::query()
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status');

            $transactionStatusLabels = collect(['dipinjam', 'dikembalikan', 'terlambat']);
            $transactionStatusSeries = $transactionStatusLabels
                ->map(fn (string $status) => (int) ($transactionStatusRaw[$status] ?? 0))
                ->values();

            $bookCategoryData = Book::query()
                ->leftJoin('categories', 'categories.id', '=', 'books.category_id')
                ->selectRaw("COALESCE(NULLIF(categories.name, ''), NULLIF(books.legacy_category, ''), NULLIF(books.category, ''), 'Tanpa Kategori') as category_name, COUNT(*) as total")
                ->groupBy('category_name')
                ->orderByDesc('total')
                ->limit(8)
                ->get();

            $dashboardData = [
                'kpi' => [
                    'members' => User::query()->role('member')->count(),
                    'books' => Book::query()->count(),
                    'transactions' => Transaction::query()->count(),
                    'active_loans' => Transaction::query()->where('status', 'dipinjam')->count(),
                    'pending_account_submissions' => AccountSubmission::query()->where('status', 'pending')->count(),
                    'pending_loan_submissions' => BorrowRequest::query()->where('status', 'pending')->count(),
                ],
                'monthly_transaction_labels' => $monthlyTransactionLabels,
                'monthly_transaction_series' => $monthlyTransactionSeries,
                'transaction_status_labels' => $transactionStatusLabels,
                'transaction_status_series' => $transactionStatusSeries,
                'book_category_labels' => $bookCategoryData->pluck('category_name')->values(),
                'book_category_series' => $bookCategoryData->pluck('total')->map(fn ($v) => (int) $v)->values(),
                'latest_transactions' => Transaction::query()
                    ->with(['member', 'book'])
                    ->latest()
                    ->limit(7)
                    ->get(),
                'low_stock_books' => Book::query()
                    ->with('bookCategory')
                    ->where('stock', '<=', 3)
                    ->orderBy('stock')
                    ->orderBy('title')
                    ->limit(8)
                    ->get(),
                'recent_account_submissions' => AccountSubmission::query()
                    ->latest()
                    ->limit(6)
                    ->get(),
                'recent_loan_submissions' => BorrowRequest::query()
                    ->with(['member', 'book'])
                    ->latest()
                    ->limit(6)
                    ->get(),
            ];
        } else {
            $memberSubmissionRaw = BorrowRequest::query()
                ->selectRaw('status, COUNT(*) as total')
                ->where('member_id', $user?->id)
                ->groupBy('status')
                ->pluck('total', 'status');

            $dashboardData = [
                'kpi' => [
                    'my_transactions' => Transaction::query()->where('member_id', $user?->id)->count(),
                    'my_active_loans' => Transaction::query()->where('member_id', $user?->id)->where('status', 'dipinjam')->count(),
                    'my_loan_submissions' => BorrowRequest::query()->where('member_id', $user?->id)->count(),
                    'pending_my_submissions' => BorrowRequest::query()->where('member_id', $user?->id)->where('status', 'pending')->count(),
                    'my_unpaid_fines' => FinePayment::query()->where('member_id', $user?->id)->where('status', 'unpaid')->sum('amount'),
                ],
                'my_submission_labels' => collect(['pending', 'approved', 'rejected']),
                'my_submission_series' => collect(['pending', 'approved', 'rejected'])
                    ->map(fn (string $status) => (int) ($memberSubmissionRaw[$status] ?? 0))
                    ->values(),
                'my_latest_transactions' => Transaction::query()
                    ->with('book')
                    ->where('member_id', $user?->id)
                    ->latest()
                    ->limit(6)
                    ->get(),
                'books_ready_to_borrow' => Book::query()
                    ->where('stock', '>', 0)
                    ->orderBy('title')
                    ->limit(8)
                    ->get(),
            ];
        }

        return view('dashboard', [
            'user' => $user,
            'role' => $role,
            'isAdmin' => $isAdmin,
            'dashboardData' => $dashboardData,
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }
}
