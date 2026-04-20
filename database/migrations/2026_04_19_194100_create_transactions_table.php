<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table): void {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->foreignId('member_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('book_id')->constrained('books')->cascadeOnDelete();
            $table->foreignId('borrow_request_id')->nullable()->constrained('borrow_requests')->nullOnDelete();
            $table->date('borrowed_at');
            $table->date('due_at');
            $table->date('extended_until')->nullable();
            $table->date('returned_at')->nullable();
            $table->unsignedInteger('late_days')->default(0);
            $table->decimal('total_fine', 12, 2)->default(0);
            $table->string('status')->default('dipinjam');
            $table->string('book_condition')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
