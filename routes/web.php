<?php

use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LoanRequestController as AdminLoanRequestController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\UserApprovalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\User\BookController as UserBookController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\LoanController as UserLoanController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/books', [LandingController::class, 'books'])->name('landing.books');
Route::get('/books/{book}', [LandingController::class, 'show'])->name('landing.books.show');
Route::get('/categories', [LandingController::class, 'categories'])->name('landing.categories');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/register/pending', [AuthController::class, 'registerPending'])->name('register.pending');
});

Route::middleware(['auth', 'account.active'])->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    })->name('dashboard');

    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function (): void {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('books', AdminBookController::class)->except(['show']);
        Route::resource('categories', AdminCategoryController::class)->except(['show']);

        Route::get('/users/pending', [UserApprovalController::class, 'index'])->name('users.pending');
        Route::post('/users/{user}/approve', [UserApprovalController::class, 'approve'])->name('users.approve');
        Route::post('/users/{user}/reject', [UserApprovalController::class, 'reject'])->name('users.reject');
        Route::post('/users/{user}/deactivate', [UserApprovalController::class, 'deactivate'])->name('users.deactivate');

        Route::get('/loan-requests', [AdminLoanRequestController::class, 'index'])->name('loan_requests.index');
        Route::get('/loan-requests/{borrowing}', [AdminLoanRequestController::class, 'show'])->name('loan_requests.show');
        Route::post('/loan-requests/{borrowing}/approve', [AdminLoanRequestController::class, 'approve'])->name('loan_requests.approve');
        Route::post('/loan-requests/{borrowing}/reject', [AdminLoanRequestController::class, 'reject'])->name('loan_requests.reject');
        Route::post('/loan-requests/{borrowing}/mark-borrowed', [AdminLoanRequestController::class, 'markBorrowed'])->name('loan_requests.mark_borrowed');
        Route::post('/loan-requests/{borrowing}/mark-returned', [AdminLoanRequestController::class, 'markReturned'])->name('loan_requests.mark_returned');

        Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
    });

    Route::prefix('user')->name('user.')->middleware('role:user')->group(function (): void {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

        Route::get('/books', [UserBookController::class, 'index'])->name('books.index');
        Route::get('/books/{book}', [UserBookController::class, 'show'])->name('books.show');

        Route::get('/loans', [UserLoanController::class, 'index'])->name('loans.index');
        Route::get('/loans/create', [UserLoanController::class, 'create'])->name('loans.create');
        Route::post('/loans', [UserLoanController::class, 'store'])->name('loans.store');
        Route::get('/loans/{borrowing}', [UserLoanController::class, 'show'])->name('loans.show');

        Route::get('/profile', [UserProfileController::class, 'index'])->name('profile.index');
    });
});
