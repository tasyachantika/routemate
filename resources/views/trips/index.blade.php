@extends('layouts.app')

@section('title', __('Itinerary Saya') . ' - RouteMate')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">{{ __('Itinerary Saya') }}</h1>
        <a href="{{ route('trips.create') }}" class="btn btn-primary">+ {{ __('Buat Itinerary Baru') }}</a>
    </div>

    <div class="row">
        @forelse ($trips as $trip)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <span class="badge bg-secondary">{{ __($statuses[$trip->status] ?? $trip->status) }}</span>
                        <h5 class="card-title mt-2">{{ $trip->title }}</h5>
                        <p class="text-muted mb-1">{{ $trip->destination_country ?? __('Negara tujuan belum diisi') }}</p>
                        <p class="mb-1">
                            {{ $trip->start_date ? \Carbon\Carbon::parse($trip->start_date)->translatedFormat('d F Y') : '...' }}
                            {{ __('s/d') }}
                            {{ $trip->end_date ? \Carbon\Carbon::parse($trip->end_date)->translatedFormat('d F Y') : '...' }}
                        </p>
                        <p class="mb-0">{{ __('Mata uang:') }} {{ $trip->currency }} &middot; {{ $trip->details_count }} {{ __('destinasi') }}</p>
                    </div>
                    <div class="card-footer bg-white border-0 pb-3 d-flex gap-2">
                        <a href="{{ route('trips.show', $trip) }}" class="btn btn-outline-primary flex-grow-1">{{ __('Buka') }}</a>
                        <a href="{{ route('trips.edit', $trip) }}" class="btn btn-outline-secondary">{{ __('Edit') }}</a>
                        <form method="POST" action="{{ route('trips.destroy', $trip) }}" onsubmit="return confirm('{{ __("Hapus itinerary ini beserta seluruh isinya?") }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">{{ __('Hapus') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">{{ __('Kamu belum punya itinerary. Klik tombol "Buat Itinerary Baru" untuk memulai perjalanan pertamamu.') }}</div>
            </div>
        @endforelse
    </div>
@endsection
