@extends('layouts.app', ['title' => 'Profil Saya'])

@section('content')
<section class="mx-auto max-w-2xl rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <h1 class="mb-4 text-xl font-bold">Profil Saya</h1>
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">@csrf @method('PUT')
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div><label class="mb-1 block text-sm">Nama</label><input name="name" value="{{ old('name',$user->name) }}" class="w-full rounded border px-3 py-2" required></div>
            <div><label class="mb-1 block text-sm">Username</label><input name="username" value="{{ old('username',$user->username) }}" class="w-full rounded border px-3 py-2" required></div>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div><label class="mb-1 block text-sm">Email</label><input name="email" type="email" value="{{ old('email',$user->email) }}" class="w-full rounded border px-3 py-2" required></div>
            <div><label class="mb-1 block text-sm">No HP</label><input name="phone" value="{{ old('phone',$user->phone) }}" class="w-full rounded border px-3 py-2" required></div>
        </div>
        <div><label class="mb-1 block text-sm">Alamat</label><textarea name="address" class="w-full rounded border px-3 py-2" rows="3" required>{{ old('address',$user->address) }}</textarea></div>
        <div><label class="mb-1 block text-sm">Foto Profil</label><input type="file" name="photo" class="w-full rounded border px-3 py-2"></div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div><label class="mb-1 block text-sm">Password Baru (opsional)</label><input type="password" name="password" class="w-full rounded border px-3 py-2"></div>
            <div><label class="mb-1 block text-sm">Konfirmasi Password</label><input type="password" name="password_confirmation" class="w-full rounded border px-3 py-2"></div>
        </div>
        <button class="rounded bg-blue-600 px-3 py-2 text-sm text-white">Simpan Perubahan</button>
    </form>
</section>
@endsection
