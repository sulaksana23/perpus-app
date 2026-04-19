<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PromoteUserToAdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = (string) env('PROMOTE_ADMIN_EMAIL', 'admin@example.com');

        $user = User::query()->where('email', $email)->first();

        if (! $user) {
            $this->command?->error("User dengan email {$email} tidak ditemukan.");

            return;
        }

        Role::findOrCreate('admin', 'web');

        $user->update([
            'role' => 'admin',
            'is_approved' => true,
            'status' => 'active',
        ]);

        $user->syncRoles(['admin']);

        $this->command?->info("User {$email} berhasil dipromosikan menjadi admin.");
    }
}
