@extends('layouts.app')

@section('title', $destination->name . ' - RouteMate')

@section('content')
    <a href="{{ route('destinations.index') }}" class="btn btn-outline-secondary mb-3">&larr; Kembali ke Daftar Destinasi</a>

    <div class="card">
        @if ($destination->photo)
            <img src="{{ asset('storage/' . $destination->photo) }}" class="card-img-top" style="max-height: 380px; object-fit: cover;" alt="{{ $destination->name }}">
        @else
            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 240px;">
                <span>Foto belum tersedia</span>
            </div>
        @endif
        <div class="card-body">
            <span class="badge bg-primary">{{ $destination->category->name ?? 'Tanpa Kategori' }}</span>
            <h1 class="mt-2">{{ $destination->name }}</h1>
            <p class="text-muted">{{ $destination->city }}, {{ $destination->country }}</p>
            <p>{{ $destination->description }}</p>

            <table class="table table-bordered mt-3">
                <tr>
                    <th style="width: 220px;">Alamat</th>
                    <td>{{ $destination->address ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Koordinat</th>
                    <td>{{ $destination->latitude }}, {{ $destination->longitude }}</td>
                </tr>
                <tr>
                    <th>Perkiraan Biaya Masuk</th>
                    <td>{{ $destination->entrance_fee !== null ? number_format($destination->entrance_fee, 0, ',', '.') : 'Gratis / tidak diketahui' }}</td>
                </tr>
            </table>

            <h2 class="h5 mt-4">Lokasi pada Peta</h2>
            <div id="map" style="height: 320px;" class="rounded border"></div>

            <h2 class="h5 mt-4">Tambah ke Itinerary Saya</h2>
            @if ($userTrips->isEmpty())
            <p class="text-muted">Kamu belum punya itinerary. <a href="{{ route('trips.create') }}">Buat itinerary baru</a> dulu, lalu kembali ke halaman ini.</p>
            @else
            <div class="d-flex flex-wrap gap-2">
                @foreach ($userTrips as $userTrip)
                <form method="POST" action="{{ route('trips.details.store', $userTrip) }}" class="m-0">
                    @csrf
                    <input type="hidden" name="destination_id" value="{{ $destination->id }}">
                    <button type="submit" class="btn btn-outline-primary btn-sm">+ Tambah ke: {{ $userTrip->title }}</button>
                </form>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    @endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const latitude = @json((float) $destination->latitude);
        const longitude = @json((float) $destination->longitude);
        const name = @json($destination->name);

        const map = L.map('map').setView([latitude, longitude], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        const marker = L.marker([latitude, longitude]).addTo(map);
        const label = document.createElement('strong');
        label.textContent = name;
        marker.bindPopup(label);
    </script>
@endpush
