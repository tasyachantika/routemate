@extends('layouts.app')

@section('title', 'Destinasi - RouteMate')

@section('content')
    <h1 class="mb-3">Jelajahi Destinasi</h1>

    <form method="GET" action="{{ route('destinations.index') }}" class="card card-body mb-4">
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="q" class="form-control" maxlength="100" placeholder="Cari nama, kota, atau negara..." value="{{ $filters['q'] ?? '' }}">
            </div>
            <div class="col-md-3">
                <select name="country" class="form-select">
                    <option value="">Semua Negara</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country }}" @selected(($filters['country'] ?? '') === $country)>{{ $country }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) ($filters['category_id'] ?? '') === (string) $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">Cari</button>
                <a href="{{ route('destinations.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </div>
    </form>

    <p class="text-muted">Ditemukan {{ $destinations->count() }} destinasi.</p>

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
                        @if ($destination->entrance_fee !== null)
                            <p class="mb-1 small"><span class="text-muted">Tiket masuk:</span> <strong>{{ \App\Support\Money::entranceFee((float) $destination->entrance_fee, $destination->country) }}</strong> <span class="text-muted">(perkiraan)</span></p>
                        @endif
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($destination->description, 100) }}</p>
                    </div>
                    <div class="card-footer bg-white border-0 pb-3">
                        <a href="{{ route('destinations.show', $destination) }}" class="btn btn-outline-primary w-100">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Tidak ada destinasi yang cocok dengan pencarianmu. Coba kata kunci atau filter lain, atau klik Reset.</div>
            </div>
        @endforelse
    </div>
@endsection
