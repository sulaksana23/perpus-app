<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('q')->toString());
        $categoryId = $request->integer('category_id');

        $books = Book::query()
            ->select(['id', 'code', 'title', 'author', 'category_id', 'cover', 'stock', 'created_at'])
            ->with('category:id,name')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($inner) use ($search): void {
                    $inner->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->when($categoryId > 0, fn ($query) => $query->where('category_id', $categoryId))
            ->latest()
            // simplePaginate lebih ringan karena tidak menjalankan total-count query.
            ->simplePaginate(12)
            ->withQueryString();

        return view('landing.index', [
            'books' => $books,
            'search' => $search,
            'categoryId' => $categoryId,
            'categories' => Cache::remember('landing_active_categories', now()->addMinutes(15), function () {
                return Category::query()
                    ->select(['id', 'name'])
                    ->where('is_active', true)
                    ->orderBy('name')
                    ->get();
            }),
        ]);
    }

    public function books(Request $request): View
    {
        return $this->index($request);
    }

    public function show(Book $book): View
    {
        $book->load('category');

        return view('landing.book-detail', [
            'book' => $book,
            'relatedBooks' => Book::query()
                ->whereKeyNot($book->id)
                ->when($book->category_id, fn ($query) => $query->where('category_id', $book->category_id))
                ->latest()
                ->limit(4)
                ->get(),
        ]);
    }

    public function categories(): View
    {
        return view('landing.categories', [
            'categories' => Category::query()
                ->withCount('books')
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),
        ]);
    }
}
