@extends('layouts.app')

@section('title', '500 — Terjadi Kesalahan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 text-center">
            <div class="display-1 fw-bold text-danger">500</div>
            <h1 class="h3 mb-3">Terjadi Kesalahan pada Server</h1>
            <p class="text-muted">
                Maaf, ada gangguan saat memproses permintaanmu. Silakan coba
                beberapa saat lagi. Demi keamanan, detail teknis kesalahan
                tidak ditampilkan di halaman ini.
            </p>
            <a href="{{ url('/') }}" class="btn btn-primary">Ke Halaman Utama</a>
        </div>
    </div>
</div>
@endsection
