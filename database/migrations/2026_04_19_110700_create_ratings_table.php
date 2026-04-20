<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $hasBooksTable = Schema::hasTable('books');

        Schema::create('ratings', function (Blueprint $table) use ($hasBooksTable): void {
            $table->id();
            $table->foreignId('member_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('book_id');
            if ($hasBooksTable) {
                $table->foreign('book_id')->references('id')->on('books')->cascadeOnDelete();
            }
            $table->unsignedTinyInteger('rating');
            $table->text('review')->nullable();
            $table->timestamps();

            $table->unique(['member_id', 'book_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
