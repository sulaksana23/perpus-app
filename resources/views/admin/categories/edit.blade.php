@extends('layouts.admin', ['title' => 'Edit Kategori'])

@section('content')
<form method="POST" action="{{ route('admin.categories.update', $category) }}" class="card card-body">
    @csrf @method('PUT')
    @include('admin.categories.partials.form')
    <button class="btn btn-primary">Update</button>
</form>
@endsection
