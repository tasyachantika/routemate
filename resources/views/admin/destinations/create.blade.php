@extends('layouts.admin')

@section('title', __('Tambah Destinasi') . ' - Admin RouteMate')

@section('content')
    <h1 class="mb-3">{{ __('Tambah Destinasi') }}</h1>

    <form method="POST" action="{{ route('admin.destinations.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.destinations._form')
        <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
        <a href="{{ route('admin.destinations.index') }}" class="btn btn-secondary">{{ __('Kembali') }}</a>
    </form>
@endsection
