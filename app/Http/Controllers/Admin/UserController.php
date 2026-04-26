<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('q')->toString());
        $role = trim($request->string('role')->toString());

        $users = User::query()
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($inner) use ($search): void {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%");
                });
            })
            ->when(in_array($role, ['admin', 'user'], true), fn ($query) => $query->where('role', $role))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'search', 'role'));
    }

    public function create(): View
    {
        return view('admin.users.create', [
            'user' => new User(),
            'roleOptions' => $this->roleOptions(),
            'statusOptions' => $this->statusOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePayload($request);

        $user = User::query()->create($this->normalizePayload($validated));

        return redirect()->route('admin.users.index')->with('success', "Akun {$user->email} berhasil ditambahkan.");
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
            'roleOptions' => $this->roleOptions(),
            'statusOptions' => $this->statusOptions(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $this->validatePayload($request, $user);

        $user->update($this->normalizePayload($validated, $user));

        return redirect()->route('admin.users.index')->with('success', "Akun {$user->email} berhasil diperbarui.");
    }

    public function destroy(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return back()->with('success', 'Akun berhasil dihapus.');
    }

    private function validatePayload(Request $request, ?User $user = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:50', Rule::unique('users', 'username')->ignore($user?->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user?->id)],
            'phone' => ['nullable', 'string', 'max:25'],
            'address' => ['nullable', 'string'],
            'role' => ['required', Rule::in($this->roleOptions())],
            'status_akun' => ['required', Rule::in($this->statusOptions())],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    private function normalizePayload(array $validated, ?User $user = null): array
    {
        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        if ($validated['role'] === 'admin') {
            $validated['status_akun'] = 'active';
        }

        $validated['is_approved'] = $validated['status_akun'] === 'active';
        $validated['status'] = $validated['status_akun'] === 'active' ? 'active' : 'inactive';

        return $validated;
    }

    private function roleOptions(): array
    {
        return ['admin', 'user'];
    }

    private function statusOptions(): array
    {
        return ['active', 'pending', 'rejected'];
    }
}
