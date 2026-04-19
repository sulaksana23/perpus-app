<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorrowRequestController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AccountSubmissionController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/katalog', [LandingController::class, 'books'])->name('landing.books');
Route::get('/katalog/{book}', [LandingController::class, 'showBook'])->name('landing.books.show');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profil-saya', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil-saya', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/pengajuan-peminjaman/create', [BorrowRequestController::class, 'create'])->name('borrow-requests.create');
    Route::post('/pengajuan-peminjaman', [BorrowRequestController::class, 'store'])->name('borrow-requests.store');

    Route::middleware('admin')->group(function (): void {
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('members', MemberController::class)->except(['show']);
        Route::resource('books', BookController::class)->except(['show']);
        Route::resource('transactions', TransactionController::class)->except(['show']);
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('fines', FineController::class)->except(['show']);

        Route::get('/pengajuan-akun', [AccountSubmissionController::class, 'index'])->name('account-submissions.index');
        Route::post('/pengajuan-akun/{accountSubmission}/approve', [AccountSubmissionController::class, 'approve'])->name('account-submissions.approve');
        Route::post('/pengajuan-akun/{accountSubmission}/reject', [AccountSubmissionController::class, 'reject'])->name('account-submissions.reject');

        Route::get('/pengajuan-peminjaman', [BorrowRequestController::class, 'index'])->name('borrow-requests.index');
        Route::post('/pengajuan-peminjaman/{borrowRequest}/approve', [BorrowRequestController::class, 'approve'])->name('borrow-requests.approve');
        Route::post('/pengajuan-peminjaman/{borrowRequest}/reject', [BorrowRequestController::class, 'reject'])->name('borrow-requests.reject');
        Route::post('/transaksi/{transaction}/pengembalian', [BorrowRequestController::class, 'returnBook'])->name('transactions.return');
    });
});
