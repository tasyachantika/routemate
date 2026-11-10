@extends('layouts.app')

@section('title', 'Itinerary Saya - RouteMate')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Itinerary Saya</h1>
        <a href="{{ route('trips.create') }}" class="btn btn-primary">+ Buat Itinerary Baru</a>
    </div>

    <div class="row">
        @forelse ($trips as $trip)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <span class="badge bg-secondary">{{ $statuses[$trip->status] ?? $trip->status }}</span>
                        <h5 class="card-title mt-2">{{ $trip->title }}</h5>
                        <p class="text-muted mb-1">{{ $trip->destination_country ?? 'Negara tujuan belum diisi' }}</p>
                        <p class="mb-1">
                            {{ $trip->start_date ? substr((string) $trip->start_date, 0, 10) : '...' }}
                            s/d
                            {{ $trip->end_date ? substr((string) $trip->end_date, 0, 10) : '...' }}
                        </p>
                        <p class="mb-0">Mata uang: {{ $trip->currency }} &middot; {{ $trip->details_count }} destinasi</p>
                    </div>
                    <div class="card-footer bg-white border-0 pb-3 d-flex gap-2">
                        <a href="{{ route('trips.show', $trip) }}" class="btn btn-outline-primary flex-grow-1">Buka</a>
                        <a href="{{ route('trips.edit', $trip) }}" class="btn btn-outline-secondary">Edit</a>
                        <form method="POST" action="{{ route('trips.destroy', $trip) }}" onsubmit="return confirm('Hapus itinerary ini beserta seluruh isinya?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Kamu belum punya itinerary. Klik tombol "Buat Itinerary Baru" untuk memulai perjalanan pertamamu.</div>
            </div>
        @endforelse
    </div>
@endsection
