<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            if (! Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->nullable()->after('name');
            }
            if (! Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (! Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('phone');
            }
            if (! Schema::hasColumn('users', 'photo')) {
                $table->string('photo')->nullable()->after('address');
            }
            if (! Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('active')->after('photo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $columns = ['username', 'phone', 'address', 'photo', 'status'];

            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
