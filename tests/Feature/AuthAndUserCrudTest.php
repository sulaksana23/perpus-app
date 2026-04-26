<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Tests\TestCase;

class AuthAndUserCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(ValidateCsrfToken::class);
    }

    public function test_active_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'password' => 'password123',
            'role' => 'user',
            'status_akun' => 'active',
            'is_approved' => true,
            'status' => 'active',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('user.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_guest_can_register_and_account_becomes_pending(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'User Baru',
            'email' => 'baru@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('register.pending'));

        $this->assertDatabaseHas('users', [
            'email' => 'baru@example.com',
            'role' => 'user',
            'status_akun' => 'pending',
            'is_approved' => false,
            'status' => 'inactive',
        ]);
    }

    public function test_admin_can_access_user_approval_page(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.users.pending'))
            ->assertOk();
    }

    public function test_admin_can_create_update_and_delete_user_from_admin_crud(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
        ]);

        $createResponse = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Member Baru',
            'username' => 'memberbaru',
            'email' => 'memberbaru@example.com',
            'phone' => '08123456789',
            'address' => 'Alamat awal',
            'role' => 'user',
            'status_akun' => 'active',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $createResponse->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'memberbaru@example.com',
            'role' => 'user',
            'status_akun' => 'active',
        ]);

        $user = User::query()->where('email', 'memberbaru@example.com')->firstOrFail();

        $updateResponse = $this->actingAs($admin)->put(route('admin.users.update', $user), [
            'name' => 'Admin Baru',
            'username' => 'adminbaru',
            'email' => 'adminbaru@example.com',
            'phone' => '08999999999',
            'address' => 'Alamat update',
            'role' => 'admin',
            'status_akun' => 'pending',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $updateResponse->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'adminbaru@example.com',
            'role' => 'admin',
            'status_akun' => 'active',
        ]);

        $deleteResponse = $this->actingAs($admin)->delete(route('admin.users.destroy', $user));

        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    public function test_regular_user_cannot_access_admin_user_approval_page(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'status_akun' => 'active',
            'is_approved' => true,
            'status' => 'active',
        ]);

        $this->actingAs($user)
            ->get(route('admin.users.pending'))
            ->assertForbidden();
    }

    public function test_user_can_update_own_profile(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'status_akun' => 'active',
            'is_approved' => true,
            'status' => 'active',
            'username' => 'lamauser',
            'phone' => '0811111111',
            'address' => 'Alamat lama',
        ]);

        $response = $this->actingAs($user)->put(route('user.profile.update'), [
            'name' => 'Nama Baru',
            'username' => 'userbaru',
            'email' => 'userbaru@example.com',
            'phone' => '0822222222',
            'address' => 'Alamat baru',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nama Baru',
            'username' => 'userbaru',
            'email' => 'userbaru@example.com',
            'phone' => '0822222222',
            'address' => 'Alamat baru',
        ]);
    }
}
