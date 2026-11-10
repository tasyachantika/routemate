@extends('layouts.app')

@section('title', __('Peta Destinasi') . ' - RouteMate')

@section('content')
    <h1 class="mb-3">{{ __('Peta Destinasi') }}</h1>

    <form method="GET" action="{{ route('map.index') }}" class="card card-body mb-3">
        <div class="row g-2">
            <div class="col-md-6">
                <input type="text" name="q" class="form-control" maxlength="100" placeholder="{{ __('Cari nama, kota, atau negara...') }}" value="{{ $filters['q'] ?? '' }}">
            </div>
            <div class="col-md-4">
                <select name="country" class="form-select">
                    <option value="">{{ __('Semua Negara') }}</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country }}" @selected(($filters['country'] ?? '') === $country)>{{ $country }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">{{ __('Cari') }}</button>
                <a href="{{ route('map.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </div>
    </form>

    <p class="text-muted">{{ __('Menampilkan') }} {{ $destinations->count() }} {{ __('destinasi pada peta. Klik penanda (marker) untuk melihat ringkasannya.') }}</p>

    <div id="map" style="height: 560px;" class="rounded border"></div>

    @if ($destinations->isEmpty())
        <div class="alert alert-info mt-3">{{ __('Tidak ada destinasi yang cocok dengan pencarianmu, jadi tidak ada marker yang ditampilkan.') }}</div>
    @endif
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const destinations = @json($mapDestinations);
        const detailText = @json(__('Lihat Detail'));

        const map = L.map('map').setView([-2.5489, 118.0149], 4);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        const bounds = [];

        destinations.forEach(function (destination) {
            const marker = L.marker([destination.latitude, destination.longitude]).addTo(map);

            const box = document.createElement('div');
            const title = document.createElement('strong');
            title.textContent = destination.name;
            const location = document.createElement('div');
            location.textContent = destination.city + ', ' + destination.country;
            const category = document.createElement('div');
            category.textContent = destination.category;
            const link = document.createElement('a');
            link.href = destination.detail_url;
            link.textContent = detailText;
            link.className = 'btn btn-sm btn-primary mt-2';

            box.appendChild(title);
            box.appendChild(document.createElement('br'));
            box.appendChild(location);
            box.appendChild(category);
            box.appendChild(link);

            marker.bindPopup(box);
            bounds.push([destination.latitude, destination.longitude]);
        });

        if (bounds.length > 0) {
            map.fitBounds(bounds, { padding: [40, 40], maxZoom: 11 });
        }
    </script>
@endpush
