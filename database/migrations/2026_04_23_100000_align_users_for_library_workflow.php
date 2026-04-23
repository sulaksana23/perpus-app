<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            if (! Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('password');
            }

            if (! Schema::hasColumn('users', 'status_akun')) {
                $table->string('status_akun')->default('pending')->after('role');
            }

            if (! Schema::hasColumn('users', 'is_approved')) {
                $table->boolean('is_approved')->default(false)->after('status_akun');
            }
        });

        DB::table('users')
            ->whereNull('role')
            ->update(['role' => 'user']);

        DB::table('users')
            ->whereIn('role', ['member'])
            ->update(['role' => 'user']);

        DB::table('users')
            ->whereIn('role', ['super-admin'])
            ->update(['role' => 'admin']);

        DB::table('users')
            ->whereNull('status_akun')
            ->update(['status_akun' => 'pending']);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            if (Schema::hasColumn('users', 'status_akun')) {
                $table->dropColumn('status_akun');
            }
        });
    }
};
