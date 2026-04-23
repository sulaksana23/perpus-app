@extends('layouts.user', ['title' => 'Profil Saya'])

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="mb-3">Profil User</h5>
        <p class="mb-1"><strong>Nama:</strong> {{ $user->name }}</p>
        <p class="mb-1"><strong>Email:</strong> {{ $user->email }}</p>
        <p class="mb-1"><strong>Role:</strong> {{ $user->role }}</p>
        <p class="mb-0"><strong>Status Akun:</strong> {{ $user->status_akun }}</p>
    </div>
</div>
@endsection
