@extends('layouts.app')

@section('title', '404 — ' . __('Halaman Tidak Ditemukan'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 text-center">
            <div class="display-1 fw-bold text-primary">404</div>
            <h1 class="h3 mb-3">{{ __('Halaman Tidak Ditemukan') }}</h1>
            <p class="text-muted">
                {{ __('Alamat yang kamu buka tidak ada, sudah dipindahkan, atau data yang dicari memang bukan milik akunmu. Periksa kembali alamatnya, atau kembali ke halaman utama untuk melanjutkan.') }}
            </p>
            <a href="{{ url('/') }}" class="btn btn-primary">{{ __('Ke Halaman Utama') }}</a>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">{{ __('Ke Dashboard') }}</a>
            @endauth
        </div>
    </div>
</div>
@endsection
