<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthAndUserCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(ValidateCsrfToken::class);

        Role::findOrCreate('super-admin', 'web');
        Role::findOrCreate('admin', 'web');
        Role::findOrCreate('member', 'web');
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'password' => 'password123',
        ]);
        $user->assignRole('member');

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_guest_can_register_and_get_super_admin_role(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'User Baru',
            'email' => 'baru@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));

        $user = User::where('email', 'baru@example.com')->firstOrFail();
        $this->assertTrue($user->hasRole('super-admin'));
    }

    public function test_admin_can_create_update_and_delete_user(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        $createResponse = $this->post(route('users.store'), [
            'name' => 'Member A',
            'email' => 'membera@example.com',
            'password' => 'password123',
            'role' => 'member',
        ]);

        $createResponse->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'membera@example.com',
        ]);

        $user = User::where('email', 'membera@example.com')->firstOrFail();
        $this->assertTrue($user->hasRole('member'));

        $updateResponse = $this->put(route('users.update', $user), [
            'name' => 'Member B',
            'email' => 'memberb@example.com',
            'password' => '',
            'role' => 'admin',
        ]);

        $updateResponse->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Member B',
            'email' => 'memberb@example.com',
        ]);
        $this->assertTrue($user->fresh()->hasRole('admin'));

        $deleteResponse = $this->delete(route('users.destroy', $user));

        $deleteResponse->assertRedirect(route('users.index'));
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    public function test_member_cannot_access_user_crud_routes(): void
    {
        $member = User::factory()->create();
        $member->assignRole('member');

        $this->actingAs($member)
            ->get(route('users.index'))
            ->assertForbidden();
    }
}
