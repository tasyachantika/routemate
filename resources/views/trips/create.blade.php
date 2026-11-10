@extends('layouts.app')

@section('title', __('Buat Itinerary') . ' - RouteMate')

@section('content')
    <h1 class="mb-3">{{ __('Buat Itinerary Baru') }}</h1>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('trips.store') }}">
                @csrf
                @include('trips._form')
                <button type="submit" class="btn btn-primary">{{ __('Simpan Itinerary') }}</button>
                <a href="{{ route('trips.index') }}" class="btn btn-outline-secondary">{{ __('Batal') }}</a>
            </form>
        </div>
    </div>
@endsection
