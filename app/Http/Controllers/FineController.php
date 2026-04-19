<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class FineController extends Controller
{
    public function index(): View
    {
        $fines = Fine::query()->latest()->paginate(10);

        return view('fines.index', compact('fines'));
    }

    public function create(): View
    {
        return view('fines.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'type' => ['required', 'in:fixed,per_day,percentage,full_price'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Fine::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'amount' => $validated['amount'],
            'type' => $validated['type'],
            'description' => $validated['description'] ?? null,
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        return redirect()->route('fines.index')->with('success', 'Master denda berhasil ditambahkan.');
    }

    public function edit(Fine $fine): View
    {
        return view('fines.edit', compact('fine'));
    }

    public function update(Request $request, Fine $fine): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'type' => ['required', 'in:fixed,per_day,percentage,full_price'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $fine->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'amount' => $validated['amount'],
            'type' => $validated['type'],
            'description' => $validated['description'] ?? null,
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return redirect()->route('fines.index')->with('success', 'Master denda berhasil diperbarui.');
    }

    public function destroy(Fine $fine): RedirectResponse
    {
        $fine->delete();

        return redirect()->route('fines.index')->with('success', 'Master denda berhasil dihapus.');
    }
}
