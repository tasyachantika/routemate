@extends('layouts.app')

@section('title', 'Lupa Password - RouteMate')

@section('content')
<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="h3 mb-3">Lupa Password</h1>
                    <p class="text-muted">Masukkan email akunmu. Kami akan mengirimkan tautan untuk membuat password baru. Tautan hanya berlaku terbatas dan hanya bisa dipakai satu kali.</p>

                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Kirim Tautan Reset</button>
                    </form>

                    <p class="mt-3 mb-0">Ingat passwordmu? <a href="{{ route('login') }}">Kembali masuk</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
