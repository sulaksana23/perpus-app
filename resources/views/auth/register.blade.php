@extends('layouts.app', ['title' => 'Register'])

@section('content')
    <section class="mx-auto mt-8 max-w-lg rounded-xl border border-slate-200 bg-white p-4 shadow-sm md:p-5">
        <h1 class="text-xl font-bold text-slate-900">Register Anggota</h1>
        <p class="mt-1 text-sm text-slate-500">Akun baru akan berstatus <span class="font-semibold">PENDING</span> sampai disetujui admin.</p>

        <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-4">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Nama lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label for="username" class="mb-1 block text-sm font-medium text-slate-700">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label for="phone" class="mb-1 block text-sm font-medium text-slate-700">No HP</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>
            </div>
            <div>
                <label for="address" class="mb-1 block text-sm font-medium text-slate-700">Alamat</label>
                <textarea id="address" name="address" rows="3" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ old('address') }}</textarea>
            </div>
            <div>
                <label for="photo" class="mb-1 block text-sm font-medium text-slate-700">Foto Profil (opsional)</label>
                <input type="file" id="photo" name="photo" accept="image/*" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Password</label>
                    <input type="password" id="password" name="password" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label for="password_confirmation" class="mb-1 block text-sm font-medium text-slate-700">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>
            </div>
            <div>
                <label for="notes" class="mb-1 block text-sm font-medium text-slate-700">Catatan Pengajuan (opsional)</label>
                <textarea id="notes" name="notes" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ old('notes') }}</textarea>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <button type="submit" class="rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700">Daftar</button>
                <a href="{{ route('login') }}" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kembali ke Login</a>
            </div>
        </form>
    </section>
@endsection
