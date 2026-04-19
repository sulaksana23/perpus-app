@extends('layouts.app', ['title' => 'Tambah User'])

@section('content')
    <section class="mx-auto max-w-2xl rounded-xl border border-slate-200 bg-white p-4 shadow-sm md:p-5">
        <h1 class="mb-4 flex items-center gap-2 text-xl font-bold text-slate-900">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah User
        </h1>

        <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none ring-blue-500/30 focus:border-blue-500 focus:ring">
            </div>

            <div>
                <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none ring-blue-500/30 focus:border-blue-500 focus:ring">
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Password</label>
                <input type="password" id="password" name="password" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none ring-blue-500/30 focus:border-blue-500 focus:ring">
            </div>

            <div>
                <label for="role" class="mb-1 block text-sm font-medium text-slate-700">Role</label>
                <select id="role" name="role" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none ring-blue-500/30 focus:border-blue-500 focus:ring">
                    @foreach($roles as $role)
                        <option value="{{ $role }}" @selected(old('role', 'member') === $role)>{{ ucfirst($role) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-wrap items-center gap-2 pt-1">
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Simpan
                </button>
                <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                    Batal
                </a>
            </div>
        </form>
    </section>
@endsection
