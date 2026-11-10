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

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h5"><i class="bi bi-bar-chart"></i> Laporan &amp; Statistik</h2>
                    <p class="text-muted">Destinasi terpopuler, grafik per negara dan kategori, total anggaran per mata uang, serta ekspor CSV.</p>
                    <a href="{{ route('admin.report') }}" class="btn btn-primary btn-sm">Buka Laporan</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h5"><i class="bi bi-journal-text"></i> Log Aktivitas Admin</h2>
                    <p class="text-muted">Catatan audit otomatis untuk setiap aksi tambah, ubah, dan hapus yang dilakukan admin.</p>
                    <a href="{{ route('admin.activity') }}" class="btn btn-outline-primary btn-sm">Lihat Log Aktivitas</a>
                </div>
            </div>
        </div>
    </div>
@endsection
