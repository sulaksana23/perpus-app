<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        if ($this->app->runningUnitTests()) {
            return;
        }

        if (! $this->app->isLocal() || ! Schema::hasTable('users')) {
            return;
        }

        if (User::query()->exists()) {
            return;
        }

        User::query()->create([
            'name' => 'Admin Demo',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'role' => 'admin',
            'status_akun' => 'active',
            'is_approved' => true,
            'status' => 'active',
        ]);

        User::query()->create([
            'name' => 'Admin Perpus',
            'email' => 'admin@perpus.test',
            'password' => 'password123',
            'role' => 'admin',
            'status_akun' => 'active',
            'is_approved' => true,
            'status' => 'active',
        ]);

        User::query()->create([
            'name' => 'User Aktif',
            'email' => 'user@perpus.test',
            'password' => 'password123',
            'role' => 'user',
            'status_akun' => 'active',
            'is_approved' => true,
            'status' => 'active',
        ]);
    }
}
