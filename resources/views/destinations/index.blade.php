@extends('layouts.app')

@section('title', __('Destinasi') . ' - RouteMate')

@section('content')
    <h1 class="mb-3">{{ __('Jelajahi Destinasi') }}</h1>

    <form method="GET" action="{{ route('destinations.index') }}" class="card card-body mb-4">
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="q" class="form-control" maxlength="100" placeholder="{{ __('Cari nama, kota, atau negara...') }}" value="{{ $filters['q'] ?? '' }}">
            </div>
            <div class="col-md-3">
                <select name="country" class="form-select">
                    <option value="">{{ __('Semua Negara') }}</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country }}" @selected(($filters['country'] ?? '') === $country)>{{ $country }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-select">
                    <option value="">{{ __('Semua Kategori') }}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) ($filters['category_id'] ?? '') === (string) $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">{{ __('Cari') }}</button>
                <a href="{{ route('destinations.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </div>
    </form>

    <p class="text-muted">{{ __('Ditemukan') }} {{ $destinations->count() }} {{ __('destinasi.') }}</p>

    <div class="row">
        @forelse ($destinations as $destination)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if ($destination->photo)
                        <img src="{{ asset('storage/' . $destination->photo) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $destination->name }}">
                    @else
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 180px;">
                            <span>{{ __('Foto belum tersedia') }}</span>
                        </div>
                    @endif
                    <div class="card-body">
                        <span class="badge bg-primary">{{ $destination->category->name ?? __('Tanpa Kategori') }}</span>
                        <h5 class="card-title mt-2">{{ $destination->name }}</h5>
                        <p class="text-muted mb-1">{{ $destination->city }}, {{ $destination->country }}</p>
                        @if ($destination->entrance_fee !== null)
                            <p class="mb-1 small"><span class="text-muted">{{ __('Tiket masuk:') }}</span> <strong>{{ \App\Support\Money::entranceFee((float) $destination->entrance_fee, $destination->country) }}</strong>@if ((float) $destination->entrance_fee > 0) <span class="text-muted">{{ __('(perkiraan)') }}</span>@endif</p>
                        @endif
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($destination->description, 100) }}</p>
                    </div>
                    <div class="card-footer bg-white border-0 pb-3">
                        <a href="{{ route('destinations.show', $destination) }}" class="btn btn-outline-primary w-100">{{ __('Lihat Detail') }}</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">{{ __('Tidak ada destinasi yang cocok dengan pencarianmu. Coba kata kunci atau filter lain, atau klik Reset.') }}</div>
            </div>
        @endforelse
    </div>
@endsection
