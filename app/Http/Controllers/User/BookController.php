<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BorrowingDetail;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('q')->toString());
        $categoryId = $request->integer('category_id');

        $books = Book::query()
            ->with('category')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($inner) use ($search): void {
                    $inner->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->when($categoryId > 0, fn ($query) => $query->where('category_id', $categoryId))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $activeTitles = BorrowingDetail::query()
            ->join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')
            ->join('books', 'books.id', '=', 'borrowing_details.book_id')
            ->where('borrowings.user_id', auth()->id())
            ->whereIn('borrowings.status', ['pending', 'approved', 'borrowed'])
            ->pluck('books.title')
            ->unique()
            ->values()
            ->all();

        return view('user.books.index', [
            'books' => $books,
            'search' => $search,
            'categoryId' => $categoryId,
            'categories' => Category::query()->where('is_active', true)->orderBy('name')->get(),
            'activeTitles' => $activeTitles,
        ]);
    }

    public function show(Book $book): View
    {
        $book->load('category');

        return view('user.books.show', compact('book'));
    }
}
