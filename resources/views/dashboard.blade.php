@extends('layouts.app')

@section('title', 'Dashboard - RouteMate')

@section('content')
    <h1 class="mb-3">Dashboard Pengguna</h1>
    <p>Halo, {{ auth()->user()->name }}! Selamat datang di RouteMate.</p>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h2>{{ $tripsCount }}</h2>
                    <p class="text-muted mb-0">Itinerary Saya</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h2>{{ $destinationsCount }}</h2>
                    <p class="text-muted mb-0">Destinasi Tersedia</p>
                </div>
            </div>
        </div>
    </div>

    <p class="text-muted">Fitur menyusun itinerary akan aktif pada tahap itinerary. Untuk sekarang, jelajahi destinasi dari halaman utama.</p>
@endsection
