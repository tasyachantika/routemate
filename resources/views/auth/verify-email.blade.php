@extends('layouts.app')

@section('title', __('Verifikasi Email') . ' - RouteMate')

@section('content')
<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="h3 mb-3">{{ __('Verifikasi Email Kamu') }}</h1>
                    <p class="text-muted">
                        {{ __('Kami sudah mengirim tautan verifikasi ke email kamu. Klik tautan itu untuk memastikan email ini benar milikmu. Kamu tetap bisa memakai RouteMate sambil menunggu verifikasi.') }}
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success">{{ __('Tautan verifikasi baru sudah dikirim ke email kamu.') }}</div>
                    @endif

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100">{{ __('Kirim Ulang Email Verifikasi') }}</button>
                    </form>

                    <p class="mt-3 mb-0"><a href="{{ route('dashboard') }}">{{ __('Kembali ke Dashboard') }}</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
