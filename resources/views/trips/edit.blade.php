@extends('layouts.app')

@section('title', 'Edit Itinerary - RouteMate')

@section('content')
    <h1 class="mb-3">Edit Itinerary</h1>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('trips.update', $trip) }}">
                @csrf
                @method('PUT')
                @include('trips._form')
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('trips.show', $trip) }}" class="btn btn-outline-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
