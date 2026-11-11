@extends('layouts.app')

@section('title', __($destination->name) . ' - RouteMate')

@section('content')
    <a href="{{ route('destinations.index') }}" class="btn btn-outline-secondary mb-3">&larr; {{ __('Kembali ke Daftar Destinasi') }}</a>

    <div class="card">
        @if ($destination->photo)
            <img src="{{ asset('storage/' . $destination->photo) }}" class="card-img-top" style="max-height: 380px; object-fit: cover;" alt="{{ __($destination->name) }}">
        @else
            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 240px;">
                <span>{{ __('Foto belum tersedia') }}</span>
            </div>
        @endif
        <div class="card-body">
            <span class="badge bg-primary">{{ __($destination->category->name ?? 'Tanpa Kategori') }}</span>
            <h1 class="mt-2">{{ __($destination->name) }}</h1>
            <p class="text-muted">{{ $destination->city }}, {{ __($destination->country) }}</p>
            <p>{{ __($destination->description) }}</p>

            <table class="table table-bordered mt-3">
                <tr>
                    <th style="width: 220px;">{{ __('Alamat') }}</th>
                    <td>{{ $destination->address ?? '-' }}</td>
                </tr>
                <tr>
                    <th>{{ __('Koordinat') }}</th>
                    <td>{{ $destination->latitude }}, {{ $destination->longitude }}</td>
                </tr>
                <tr>
                    <th>{{ __('Perkiraan Biaya Masuk') }}</th>
                    <td>
                        @if ($destination->entrance_fee !== null)
                            {{ \App\Support\Money::entranceFee((float) $destination->entrance_fee, $destination->country) }}
                            <div class="text-muted small">{{ __('Perkiraan tarif standar dewasa. Harga tersimpan dalam mata uang setempat dan ditampilkan mengikuti bahasa yang dipilih, dikonversi dengan kurs perkiraan; harga dapat berubah sewaktu-waktu.') }}</div>
                        @else
                            {{ __('Gratis / tidak diketahui') }}
                        @endif
                    </td>
                </tr>
            </table>

            <h2 class="h5 mt-4">{{ __('Lokasi pada Peta') }}</h2>
            <div id="map" style="height: 320px;" class="rounded border"></div>

            <h2 class="h5 mt-4">{{ __('Tambah ke Itinerary Saya') }}</h2>
            @if ($userTrips->isEmpty())
            <p class="text-muted">{{ __('Kamu belum punya itinerary.') }} <a href="{{ route('trips.create') }}">{{ __('Buat itinerary baru') }}</a> {{ __('dulu, lalu kembali ke halaman ini.') }}</p>
            @else
            <div class="d-flex flex-wrap gap-2">
                @foreach ($userTrips as $userTrip)
                <form method="POST" action="{{ route('trips.details.store', $userTrip) }}" class="m-0">
                    @csrf
                    <input type="hidden" name="destination_id" value="{{ $destination->id }}">
                    <button type="submit" class="btn btn-outline-primary btn-sm">+ {{ __('Tambah ke:') }} {{ $userTrip->title }}</button>
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
        const name = @json(__($destination->name));

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
