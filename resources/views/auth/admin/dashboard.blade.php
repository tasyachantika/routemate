@extends('layouts.admin')

@section('title', 'Dashboard Admin - RouteMate')

@section('content')
    <h1 class="mb-3">Dashboard Admin</h1>
    <p>Halo, {{ auth()->user()->name }}. Berikut ringkasan data RouteMate saat ini.</p>

    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card text-center"><div class="card-body">
                <h2>{{ $destinationsCount }}</h2>
                <p class="text-muted mb-0">Total Destinasi</p>
            </div></div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center"><div class="card-body">
                <h2>{{ $categoriesCount }}</h2>
                <p class="text-muted mb-0">Total Kategori</p>
            </div></div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center"><div class="card-body">
                <h2>{{ $usersCount }}</h2>
                <p class="text-muted mb-0">Total Pengguna</p>
            </div></div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center"><div class="card-body">
                <h2>{{ $tripsCount }}</h2>
                <p class="text-muted mb-0">Total Itinerary</p>
            </div></div>
        </div>
    </div>

    <p class="text-muted">Menu pengelolaan kategori dan destinasi akan ditambahkan pada tahap berikutnya.</p>
@endsection
