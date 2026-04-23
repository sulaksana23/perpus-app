@extends('layouts.admin', ['title' => 'Tambah Buku'])

@section('content')
<form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data" class="card card-body d-grid gap-3">
    @csrf
    @include('admin.books.partials.form')
    <button class="btn btn-primary">Simpan</button>
</form>
@endsection
