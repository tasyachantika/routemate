@extends('layouts.app')

@section('title', 'RouteMate — ' . __('Rencanakan Perjalananmu'))

@section('content')
{{-- ===== HERO ===== --}}
<section class="hero">
    <div class="container py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge bg-light text-dark fw-semibold mb-3"><i class="bi bi-shield-check"></i> {{ __('Travel Planner dengan Keamanan Teruji') }}</span>
                <h1 class="display-5 fw-bold lh-tight">{{ __('Susun Perjalanan Impianmu,') }} <span style="color:#5eead4">{{ __('Langkah demi Langkah') }}</span></h1>
                <p class="lead mt-3">
                    {{ __('RouteMate membantumu mencari destinasi di Indonesia dan seluruh dunia, melihatnya di peta interaktif, menyusun itinerary sesuai jadwalmu, dan mencatat anggaran dalam berbagai mata uang — semua dalam satu tempat.') }}
                </p>
                <div class="d-flex flex-wrap gap-2 mt-4">
                    @auth
                        <a href="{{ route('destinations.index') }}" class="btn btn-light btn-lg fw-semibold"><i class="bi bi-compass"></i> {{ __('Jelajahi Destinasi') }}</a>
                        <a href="{{ route('map.index') }}" class="btn btn-outline-light btn-lg"><i class="bi bi-map"></i> {{ __('Buka Peta') }}</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg fw-semibold"><i class="bi bi-rocket-takeoff"></i> {{ __('Mulai Gratis') }}</a>
                        <a href="{{ url('/#destinasi') }}" class="btn btn-outline-light btn-lg"><i class="bi bi-compass"></i> {{ __('Lihat Destinasi') }}</a>
                    @endauth
                </div>
            </div>
            <div class="col-lg-5 text-center">
                <img src="{{ asset('images/logo-routemate.png') }}" alt="Logo RouteMate" class="img-fluid" style="max-height: 260px; filter: drop-shadow(0 18px 30px rgba(0,0,0,.35));">
                <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
                    <span class="badge bg-white bg-opacity-25 fs-6 fw-normal"><i class="bi bi-geo-alt"></i> {{ __('Destinasi Dunia') }}</span>
                    <span class="badge bg-white bg-opacity-25 fs-6 fw-normal"><i class="bi bi-map"></i> {{ __('Peta Interaktif') }}</span>
                    <span class="badge bg-white bg-opacity-25 fs-6 fw-normal"><i class="bi bi-wallet2"></i> {{ __('Anggaran Multi-Mata Uang') }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== FITUR ===== --}}
<section class="container py-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold">{{ __('Kenapa RouteMate?') }}</h2>
        <p class="text-muted mb-0">{{ __('Tiga hal yang membuat perencanaan perjalananmu lebih rapi dan aman.') }}</p>
    </div>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 p-4 text-center">
                <span class="feature-icon mx-auto mb-3"><i class="bi bi-map"></i></span>
                <h3 class="h5 fw-bold">{{ __('Peta Interaktif Dunia') }}</h3>
                <p class="text-muted mb-0">{{ __('Semua destinasi tampil sebagai penanda di peta Leaflet & OpenStreetMap. Klik penandanya untuk melihat ringkasan dan membuka detailnya.') }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 p-4 text-center">
                <span class="feature-icon mx-auto mb-3"><i class="bi bi-calendar2-check"></i></span>
                <h3 class="h5 fw-bold">{{ __('Itinerary Fleksibel') }}</h3>
                <p class="text-muted mb-0">{{ __('Tambahkan destinasi, atur urutan kunjungan secara manual, dan tentukan tanggal serta jam kunjungannya mengikuti zona waktu tujuanmu.') }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 p-4 text-center">
                <span class="feature-icon mx-auto mb-3"><i class="bi bi-shield-lock"></i></span>
                <h3 class="h5 fw-bold">{{ __('Aman secara Desain') }}</h3>
                <p class="text-muted mb-0">{{ __('Password ter-hash, CAPTCHA di setiap login, pembatasan hak akses user dan admin, serta perlindungan data antarpengguna — teruji, bukan sekadar klaim.') }}</p>
            </div>
        </div>
    </div>
</section>

{{-- ===== DESTINASI PILIHAN ===== --}}
<section class="container pb-5" id="destinasi">
    <div class="d-flex flex-wrap justify-content-between align-items-end mb-4">
        <div>
            <h2 class="fw-bold mb-1">{{ __('Destinasi Pilihan') }}</h2>
            <p class="text-muted mb-0">{{ __('Sebagian destinasi terbaru dari katalog RouteMate.') }}</p>
        </div>
        @auth
            <a href="{{ route('destinations.index') }}" class="btn btn-brand fw-semibold">{{ __('Lihat Semua Destinasi') }} <i class="bi bi-arrow-right"></i></a>
        @endauth
    </div>

    <div class="row g-4">
        @forelse ($destinations as $destination)
            <div class="col-md-6 col-lg-4">
                <div class="card destination-card h-100">
                    @if ($destination->photo)
                        <img src="{{ asset('storage/' . $destination->photo) }}" class="destination-img" alt="{{ __('Foto') }} {{ __($destination->name) }}">
                    @else
                        <div class="destination-placeholder"><span><i class="bi bi-image"></i> {{ __('Foto belum tersedia') }}</span></div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <div>
                            <span class="badge badge-category">{{ __($destination->category->name ?? 'Tanpa Kategori') }}</span>
                        </div>
                        <h3 class="h5 fw-bold mt-2 mb-1">{{ __($destination->name) }}</h3>
                        <p class="text-muted small mb-2"><i class="bi bi-geo-alt-fill text-danger"></i> {{ $destination->city }}, {{ __($destination->country) }}</p>
                        <p class="text-muted small flex-grow-1">{{ \Illuminate\Support\Str::limit(__($destination->description), 110) }}</p>
                        @auth
                            <a href="{{ route('destinations.show', $destination) }}" class="btn btn-outline-primary w-100 fw-semibold">{{ __('Lihat Detail') }}</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary w-100 fw-semibold">{{ __('Masuk untuk Lihat Detail') }}</a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card p-4 text-center text-muted">{{ __('Belum ada destinasi. Admin dapat menambahkannya dari panel admin.') }}</div>
            </div>
        @endforelse
    </div>
</section>

{{-- ===== AJAKAN PETA ===== --}}
<section class="container pb-5">
    <div class="card overflow-hidden">
        <div class="row g-0 align-items-center">
            <div class="col-md-8 p-4 p-lg-5">
                <h2 class="fw-bold mb-2"><i class="bi bi-pin-map brand-text"></i> {{ __('Jelajahi dari Peta') }}</h2>
                <p class="text-muted mb-3">{{ __('Lihat semua destinasi tersebar di peta dunia — dari Monas sampai Menara Eiffel — lalu susun urutan kunjunganmu sendiri.') }}</p>
                @auth
                    <a href="{{ route('map.index') }}" class="btn btn-brand btn-lg fw-semibold"><i class="bi bi-map"></i> {{ __('Buka Peta Interaktif') }}</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-brand btn-lg fw-semibold"><i class="bi bi-map"></i> {{ __('Masuk untuk Membuka Peta') }}</a>
                @endauth
            </div>
            <div class="col-md-4 text-center py-4">
                <img src="{{ asset('images/logo-routemate.png') }}" alt="Logo RouteMate" style="height: 130px; width: auto;">
            </div>
        </div>
    </div>
</section>
@endsection
