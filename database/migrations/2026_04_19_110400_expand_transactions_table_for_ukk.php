<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table): void {
            if (! Schema::hasColumn('transactions', 'code')) {
                $table->string('code')->unique()->nullable()->after('id');
            }
            if (! Schema::hasColumn('transactions', 'borrow_request_id')) {
                $table->foreignId('borrow_request_id')->nullable()->after('book_id')->constrained('borrow_requests')->nullOnDelete();
            }
            if (! Schema::hasColumn('transactions', 'extended_until')) {
                $table->date('extended_until')->nullable()->after('due_at');
            }
            if (! Schema::hasColumn('transactions', 'late_days')) {
                $table->unsignedInteger('late_days')->default(0)->after('returned_at');
            }
            if (! Schema::hasColumn('transactions', 'total_fine')) {
                $table->decimal('total_fine', 12, 2)->default(0)->after('late_days');
            }
            if (! Schema::hasColumn('transactions', 'book_condition')) {
                $table->string('book_condition')->nullable()->after('status');
            }
            if (! Schema::hasColumn('transactions', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->after('book_condition')->constrained('users')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('borrow_request_id');
            $table->dropConstrainedForeignId('approved_by');
            $table->dropColumn(['code', 'extended_until', 'late_days', 'total_fine', 'book_condition']);
        });
    }
};
