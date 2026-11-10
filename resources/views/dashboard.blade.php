@extends('layouts.app')

@section('title', 'Dashboard - RouteMate')

@section('content')
<div class="container pb-5">
    <h1 class="mb-3">Dashboard Pengguna</h1>
    <p>Halo, {{ auth()->user()->name }}! Selamat datang di RouteMate.</p>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h2>{{ $tripsCount }}</h2>
                    <p class="text-muted mb-2">Itinerary Saya</p>
                    <a href="{{ route('trips.index') }}" class="btn btn-sm btn-primary">Buka Itinerary</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h2>{{ $destinationsCount }}</h2>
                    <p class="text-muted mb-2">Destinasi Tersedia</p>
                    <a href="{{ route('destinations.index') }}" class="btn btn-sm btn-primary">Jelajahi Destinasi</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-2">
        <div class="card-body">
            <h2 class="h5">Akun Saya</h2>
            <p class="mb-1">Email: <strong>{{ auth()->user()->email }}</strong></p>
            <p class="mb-3">
                Status email:
                @if (auth()->user()->hasVerifiedEmail())
                    <span class="badge bg-success">Terverifikasi</span>
                @else
                    <span class="badge bg-warning text-dark">Belum terverifikasi</span>
                @endif
            </p>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('password.change') }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-key"></i> Ubah Password</a>
                @unless (auth()->user()->hasVerifiedEmail())
                    <a href="{{ route('verification.notice') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-envelope-check"></i> Verifikasi Email</a>
                @endunless
                <a href="{{ route('map.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-map"></i> Buka Peta</a>
            </div>
        </div>
    </div>
</div>
@endsection
