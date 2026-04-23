<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('books')) {
            Schema::create('books', function (Blueprint $table): void {
                $table->id();
                $table->string('code')->unique()->nullable();
                $table->string('title');
                $table->string('author');
                $table->string('publisher')->nullable();
                $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
                $table->string('legacy_category')->nullable();
                $table->string('rack')->nullable();
                $table->text('description')->nullable();
                $table->string('cover')->nullable();
                $table->string('category')->nullable();
                $table->string('isbn')->nullable();
                $table->unsignedInteger('stock')->default(0);
                $table->string('status')->default('tersedia');
                $table->decimal('price', 12, 2)->default(0);
                $table->decimal('avg_rating', 3, 2)->default(0);
                $table->unsignedInteger('popular_score')->default(0);
                $table->unsignedSmallInteger('published_year')->nullable();
                $table->timestamps();
            });

            return;
        }

        Schema::table('books', function (Blueprint $table): void {
            if (! Schema::hasColumn('books', 'code')) {
                $table->string('code')->unique()->nullable();
            }
            if (! Schema::hasColumn('books', 'title')) {
                $table->string('title');
            }
            if (! Schema::hasColumn('books', 'author')) {
                $table->string('author');
            }
            if (! Schema::hasColumn('books', 'publisher')) {
                $table->string('publisher')->nullable();
            }
            if (! Schema::hasColumn('books', 'category_id')) {
                $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            }
            if (! Schema::hasColumn('books', 'legacy_category')) {
                $table->string('legacy_category')->nullable();
            }
            if (! Schema::hasColumn('books', 'rack')) {
                $table->string('rack')->nullable();
            }
            if (! Schema::hasColumn('books', 'description')) {
                $table->text('description')->nullable();
            }
            if (! Schema::hasColumn('books', 'cover')) {
                $table->string('cover')->nullable();
            }
            if (! Schema::hasColumn('books', 'category')) {
                $table->string('category')->nullable();
            }
            if (! Schema::hasColumn('books', 'isbn')) {
                $table->string('isbn')->nullable();
            }
            if (! Schema::hasColumn('books', 'stock')) {
                $table->unsignedInteger('stock')->default(0);
            }
            if (! Schema::hasColumn('books', 'status')) {
                $table->string('status')->default('tersedia');
            }
            if (! Schema::hasColumn('books', 'price')) {
                $table->decimal('price', 12, 2)->default(0);
            }
            if (! Schema::hasColumn('books', 'avg_rating')) {
                $table->decimal('avg_rating', 3, 2)->default(0);
            }
            if (! Schema::hasColumn('books', 'popular_score')) {
                $table->unsignedInteger('popular_score')->default(0);
            }
            if (! Schema::hasColumn('books', 'published_year')) {
                $table->unsignedSmallInteger('published_year')->nullable();
            }
            if (! Schema::hasColumn('books', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }
            if (! Schema::hasColumn('books', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        // Intentionally empty: this is a safety/repair migration.
    }
};
