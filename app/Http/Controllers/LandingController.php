<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('q')->toString();

        $booksQuery = Book::query()
            ->with('bookCategory')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($inner) use ($search): void {
                    $inner->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            });

        $latestBooks = (clone $booksQuery)->latest()->limit(8)->get();
        $popularBooks = Book::query()->orderByDesc('popular_score')->orderByDesc('avg_rating')->limit(8)->get();

        return view('landing.index', [
            'search' => $search,
            'latestBooks' => $latestBooks,
            'popularBooks' => $popularBooks,
            'categories' => Category::query()->where('is_active', true)->orderBy('name')->get(),
            'stats' => [
                'books' => Book::query()->count(),
                'members' => User::query()->role('member')->count(),
                'borrowed' => Transaction::query()->whereIn('status', ['dipinjam', 'terlambat'])->count(),
            ],
        ]);
    }

    public function books(Request $request): View
    {
        $search = $request->string('q')->toString();
        $category = $request->string('category')->toString();

        $books = Book::query()
            ->with('bookCategory')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($inner) use ($search): void {
                    $inner->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->when($category !== '', fn ($query) => $query->whereHas('bookCategory', fn ($q) => $q->where('slug', $category)))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('landing.books', [
            'books' => $books,
            'search' => $search,
            'category' => $category,
            'categories' => Category::query()->where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function showBook(Book $book): View
    {
        $book->load(['bookCategory', 'ratings.member']);

        return view('landing.book-detail', [
            'book' => $book,
            'relatedBooks' => Book::query()
                ->whereKeyNot($book->id)
                ->when($book->category_id, fn ($q) => $q->where('category_id', $book->category_id))
                ->latest()
                ->limit(6)
                ->get(),
        ]);
    }
}
