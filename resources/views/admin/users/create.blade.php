@extends('layouts.admin', ['title' => 'Tambah User'])

@section('content')
<div class="card">
    <div class="card-header"><i class="bi bi-person-plus me-2"></i>Tambah User Baru</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.store') }}" class="d-grid gap-3">
            @csrf
            @include('admin.users.partials.form')

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
