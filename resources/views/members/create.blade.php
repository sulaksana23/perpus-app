@extends('layouts.app', ['title' => 'Tambah Anggota'])

@section('content')
    <section class="mx-auto max-w-2xl rounded-xl border border-slate-200 bg-white p-4 shadow-sm md:p-5">
        <h1 class="mb-4 text-xl font-bold text-slate-900">Tambah Anggota</h1>

        <form action="{{ route('members.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium" for="name">Nama</label>
                    <input class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" type="text" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium" for="username">Username</label>
                    <input class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" type="text" id="username" name="username" value="{{ old('username') }}" required>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium" for="email">Email</label>
                    <input class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" type="email" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium" for="phone">No HP</label>
                    <input class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" type="text" id="phone" name="phone" value="{{ old('phone') }}" required>
                </div>
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium" for="address">Alamat</label>
                <textarea class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium" for="password">Password</label>
                <input class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" type="password" id="password" name="password" required>
            </div>

            <div class="flex gap-2">
                <button class="rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700" type="submit">Simpan</button>
                <a class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50" href="{{ route('members.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection
