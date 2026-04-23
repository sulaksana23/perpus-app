@extends('layouts.admin', ['title' => 'Tambah Kategori'])

@section('content')
<form method="POST" action="{{ route('admin.categories.store') }}" class="card card-body">
    @csrf
    @include('admin.categories.partials.form')
    <button class="btn btn-primary">Simpan</button>
</form>
@endsection
