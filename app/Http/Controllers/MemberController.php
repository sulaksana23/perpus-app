<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(): View
    {
        $members = User::query()
            ->role('member')
            ->latest()
            ->paginate(10);

        return view('members.index', compact('members'));
    }

    public function create(): View
    {
        return view('members.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'phone' => ['required', 'string', 'max:25'],
            'address' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $member = User::create([
            ...$validated,
            'role' => 'member',
            'is_approved' => true,
            'status' => 'active',
        ]);

        $member->syncRoles(['member']);

        return redirect()->route('members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit(User $member): View
    {
        if (! $member->hasRole('member')) {
            abort(404);
        }

        return view('members.edit', compact('member'));
    }

    public function update(Request $request, User $member): RedirectResponse
    {
        if (! $member->hasRole('member')) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($member->id)],
            'username' => ['required', 'string', 'max:50', Rule::unique('users', 'username')->ignore($member->id)],
            'phone' => ['required', 'string', 'max:25'],
            'address' => ['required', 'string'],
            'password' => ['nullable', 'string', 'min:8'],
            'status' => ['nullable', Rule::in(['active', 'inactive'])],
        ]);

        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        $member->update([
            ...$validated,
            'status' => $validated['status'] ?? $member->status ?? 'active',
        ]);

        return redirect()->route('members.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy(User $member): RedirectResponse
    {
        if (! $member->hasRole('member')) {
            abort(404);
        }

        $member->delete();

        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
