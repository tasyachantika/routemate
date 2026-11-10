@extends('layouts.admin')

@section('title', 'Tambah Destinasi - Admin RouteMate')

@section('content')
    <h1 class="mb-3">Tambah Destinasi</h1>

    <form method="POST" action="{{ route('admin.destinations.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.destinations._form')
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.destinations.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
