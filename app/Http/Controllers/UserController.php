<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->with('roles')
            ->latest()
            ->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        $roles = $this->roleOptions();

        return view('users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in($this->roleOptions())],
        ]);

        $role = $validated['role'];
        unset($validated['role']);

        $user = User::create([
            ...$validated,
            'role' => $role,
            'is_approved' => true,
        ]);
        $user->assignRole($role);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        $roles = $this->roleOptions();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', Rule::in($this->roleOptions())],
        ]);

        $role = $validated['role'];
        unset($validated['role']);

        if (blank($validated['password'])) {
            unset($validated['password']);
        }

        $user->update([
            ...$validated,
            'role' => $role,
            'is_approved' => true,
        ]);
        $user->syncRoles([$role]);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    /**
     * @return array<int, string>
     */
    private function roleOptions(): array
    {
        Role::findOrCreate('super-admin', 'web');
        Role::findOrCreate('admin', 'web');
        Role::findOrCreate('member', 'web');

        return Role::query()
            ->orderBy('name')
            ->pluck('name')
            ->all();
    }
}
