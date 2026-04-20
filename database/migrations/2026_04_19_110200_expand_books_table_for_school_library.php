<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('books')) {
            return;
        }

        Schema::table('books', function (Blueprint $table): void {
            if (! Schema::hasColumn('books', 'code')) {
                $table->string('code')->unique()->nullable()->after('id');
            }
            if (! Schema::hasColumn('books', 'publisher')) {
                $table->string('publisher')->nullable()->after('author');
            }
            if (! Schema::hasColumn('books', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('publisher')->constrained('categories')->nullOnDelete();
            }
            if (! Schema::hasColumn('books', 'rack')) {
                $table->string('rack')->nullable()->after('category_id');
            }
            if (! Schema::hasColumn('books', 'description')) {
                $table->text('description')->nullable()->after('rack');
            }
            if (! Schema::hasColumn('books', 'cover')) {
                $table->string('cover')->nullable()->after('description');
            }
            if (! Schema::hasColumn('books', 'status')) {
                $table->string('status')->default('tersedia')->after('stock');
            }
            if (! Schema::hasColumn('books', 'price')) {
                $table->decimal('price', 12, 2)->default(0)->after('status');
            }
            if (! Schema::hasColumn('books', 'avg_rating')) {
                $table->decimal('avg_rating', 3, 2)->default(0)->after('price');
            }
            if (! Schema::hasColumn('books', 'popular_score')) {
                $table->unsignedInteger('popular_score')->default(0)->after('avg_rating');
            }
            if (Schema::hasColumn('books', 'category') && ! Schema::hasColumn('books', 'legacy_category')) {
                $table->string('legacy_category')->nullable()->after('category_id');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('books')) {
            return;
        }

        Schema::table('books', function (Blueprint $table): void {
            if (Schema::hasColumn('books', 'category_id')) {
                $table->dropConstrainedForeignId('category_id');
            }

            $columns = ['code', 'publisher', 'rack', 'description', 'cover', 'status', 'price', 'avg_rating', 'popular_score', 'legacy_category'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('books', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
