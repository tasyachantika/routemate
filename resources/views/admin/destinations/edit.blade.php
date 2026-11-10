@extends('layouts.admin')

@section('title', 'Edit Destinasi - Admin RouteMate')

@section('content')
    <h1 class="mb-3">Edit Destinasi</h1>

    <form method="POST" action="{{ route('admin.destinations.update', $destination) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.destinations._form')
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('admin.destinations.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
