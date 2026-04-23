<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table): void {
            if (! Schema::hasColumn('books', 'year')) {
                $table->unsignedSmallInteger('year')->nullable()->after('publisher');
            }
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table): void {
            if (Schema::hasColumn('books', 'year')) {
                $table->dropColumn('year');
            }
        });
    }
};
