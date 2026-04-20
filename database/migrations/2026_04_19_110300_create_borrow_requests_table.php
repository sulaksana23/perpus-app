<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $hasBooksTable = Schema::hasTable('books');

        Schema::create('borrow_requests', function (Blueprint $table) use ($hasBooksTable): void {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('member_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('book_id');
            if ($hasBooksTable) {
                $table->foreign('book_id')->references('id')->on('books')->cascadeOnDelete();
            }
            $table->text('notes')->nullable();
            $table->string('status')->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrow_requests');
    }
};
