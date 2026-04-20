<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
