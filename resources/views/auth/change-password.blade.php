@extends('layouts.app')

@section('title', __('Ubah Password') . ' - RouteMate')

@section('content')
<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="h3 mb-3">{{ __('Ubah Password') }}</h1>
                    <p class="text-muted">{{ __('Demi keamanan, password lama wajib dimasukkan dengan benar sebelum password diganti.') }}</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.change.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">{{ __('Password Lama') }}</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Password Baru') }}</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Konfirmasi Password Baru') }}</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">{{ __('Simpan Password Baru') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
