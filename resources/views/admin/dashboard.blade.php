@extends('layouts.admin')

@section('title', __('Dashboard Admin') . ' - RouteMate')

@section('content')
    <h1 class="mb-3">{{ __('Dashboard Admin') }}</h1>
    <p class="text-muted">{{ __('Halo,') }} {{ auth()->user()->name }}. {{ __('Berikut ringkasan data RouteMate saat ini.') }}</p>

    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h2 class="display-6">{{ $destinationsCount }}</h2>
                    <p class="text-muted mb-2">{{ __('Total Destinasi') }}</p>
                    <a href="{{ route('admin.destinations.index') }}" class="btn btn-sm btn-primary">{{ __('Kelola Destinasi') }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h2 class="display-6">{{ $categoriesCount }}</h2>
                    <p class="text-muted mb-2">{{ __('Total Kategori') }}</p>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-primary">{{ __('Kelola Kategori') }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h2 class="display-6">{{ $usersCount }}</h2>
                    <p class="text-muted mb-2">{{ __('Total Pengguna') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h2 class="display-6">{{ $tripsCount }}</h2>
                    <p class="text-muted mb-2">{{ __('Total Itinerary') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h5"><i class="bi bi-bar-chart"></i> {{ __('Laporan & Statistik') }}</h2>
                    <p class="text-muted">{{ __('Destinasi terpopuler, grafik per negara dan kategori, total anggaran per mata uang, serta ekspor CSV.') }}</p>
                    <a href="{{ route('admin.report') }}" class="btn btn-primary btn-sm">{{ __('Buka Laporan') }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h5"><i class="bi bi-journal-text"></i> {{ __('Log Aktivitas Admin') }}</h2>
                    <p class="text-muted">{{ __('Catatan audit otomatis untuk setiap aksi tambah, ubah, dan hapus yang dilakukan admin.') }}</p>
                    <a href="{{ route('admin.activity') }}" class="btn btn-outline-primary btn-sm">{{ __('Lihat Log Aktivitas') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
