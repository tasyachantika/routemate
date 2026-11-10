@extends('layouts.app')

@section('title', '403 — ' . __('Akses Ditolak'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 text-center">
            <div class="display-1 fw-bold text-warning">403</div>
            <h1 class="h3 mb-3">{{ __('Akses Ditolak') }}</h1>
            <p class="text-muted">
                {{ __('Akunmu tidak memiliki hak untuk membuka halaman ini. Area ini dibatasi berdasarkan peran pengguna demi keamanan data. Jika kamu merasa ini keliru, hubungi administrator.') }}
            </p>
            <a href="{{ url('/') }}" class="btn btn-primary">{{ __('Ke Halaman Utama') }}</a>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">{{ __('Ke Dashboard') }}</a>
            @endauth
        </div>
    </div>
</div>
@endsection
