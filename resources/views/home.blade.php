@extends('layouts.app')

@section('title', 'RouteMate - Rencanakan Perjalanan Wisatamu')

@section('content')
    <div class="p-5 mb-4 bg-light rounded-3">
        <h1 class="display-5 fw-bold">RouteMate</h1>
        <p class="fs-5">Rencanakan perjalanan wisatamu di dalam dan luar negeri: cari destinasi, lihat lokasinya di peta, susun urutan kunjungan, atur jadwal, dan perkirakan anggaranmu dalam satu tempat.</p>
        @guest
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Daftar Sekarang</a>
            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">Masuk</a>
        @else
            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">Ke Dashboard Saya</a>
            <a href="{{ route('map.index') }}" class="btn btn-outline-primary btn-lg">Buka Peta</a>
        @endguest
    </div>

    <h2 id="destinasi" class="mb-3">Destinasi Pilihan</h2>
    <div class="row">
        @forelse ($destinations as $destination)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if ($destination->photo)
                        <img src="{{ asset('storage/' . $destination->photo) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $destination->name }}">
                    @else
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 180px;">
                            <span>Foto belum tersedia</span>
                        </div>
                    @endif
                    <div class="card-body">
                        <span class="badge bg-primary">{{ $destination->category->name ?? 'Tanpa Kategori' }}</span>
                        <h5 class="card-title mt-2">{{ $destination->name }}</h5>
                        <p class="text-muted mb-1">{{ $destination->city }}, {{ $destination->country }}</p>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($destination->description, 100) }}</p>
                    </div>
                    <div class="card-footer bg-white border-0 pb-3">
                        @auth
                            <li class="nav-item"><a class="nav-link" href="{{ route('destinations.index') }}">Destinasi</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('map.index') }}">Peta</a></li>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">Masuk untuk Lihat Detail</a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <p>Belum ada data destinasi.</p>
        @endforelse
    </div>

    <div class="card mt-3">
        <div class="card-body text-center py-5">
            <h3>Peta Destinasi</h3>
            <p class="text-muted">Lihat semua destinasi pada peta interaktif, lengkap dengan penanda lokasi di berbagai negara.</p>
            @auth
                <a href="{{ route('map.index') }}" class="btn btn-primary">Buka Peta Interaktif</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Masuk untuk Membuka Peta</a>
            @endauth
        </div>
    </div>
@endsection
