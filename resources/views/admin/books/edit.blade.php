@extends('layouts.admin', ['title' => 'Edit Buku'])

@section('content')
<form method="POST" action="{{ route('admin.books.update', $book) }}" enctype="multipart/form-data" class="card card-body d-grid gap-3">
    @csrf @method('PUT')
    @include('admin.books.partials.form')
    <button class="btn btn-primary">Update</button>
</form>
@endsection
