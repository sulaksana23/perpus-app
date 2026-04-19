<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'author',
        'publisher',
        'category_id',
        'legacy_category',
        'rack',
        'description',
        'cover',
        'isbn',
        'stock',
        'status',
        'price',
        'avg_rating',
        'popular_score',
        'published_year',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'avg_rating' => 'decimal:2',
        ];
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function loanSubmissions(): HasMany
    {
        return $this->hasMany(LoanSubmission::class);
    }

    public function borrowRequests(): HasMany
    {
        return $this->hasMany(BorrowRequest::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function bookCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    protected function categoryLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->bookCategory?->name
                ?? $this->legacy_category
                ?? $this->getAttribute('category')
                ?? 'Tanpa Kategori',
        );
    }
}
