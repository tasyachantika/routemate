@extends('layouts.admin')

@section('title', 'Dashboard Admin - RouteMate')

@section('content')
    <h1 class="mb-3">Dashboard Admin</h1>
    <p class="text-muted">Halo, {{ auth()->user()->name }}. Berikut ringkasan data RouteMate saat ini.</p>

    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h2 class="display-6">{{ $destinationsCount }}</h2>
                    <p class="text-muted mb-2">Total Destinasi</p>
                    <a href="{{ route('admin.destinations.index') }}" class="btn btn-sm btn-primary">Kelola Destinasi</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h2 class="display-6">{{ $categoriesCount }}</h2>
                    <p class="text-muted mb-2">Total Kategori</p>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-primary">Kelola Kategori</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h2 class="display-6">{{ $usersCount }}</h2>
                    <p class="text-muted mb-2">Total Pengguna</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h2 class="display-6">{{ $tripsCount }}</h2>
                    <p class="text-muted mb-2">Total Itinerary</p>
                </div>
            </div>
        </div>
    </div>
@endsection
