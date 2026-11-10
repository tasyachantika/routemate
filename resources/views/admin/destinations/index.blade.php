@extends('layouts.admin')

@section('title', 'Destinasi - Admin RouteMate')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Kelola Destinasi</h1>
        <a href="{{ route('admin.destinations.create') }}" class="btn btn-primary">Tambah Destinasi</a>
    </div>

    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr><th>Foto</th><th>Nama</th><th>Negara / Kota</th><th>Kategori</th><th>Koordinat</th><th>Biaya Masuk</th><th style="width: 180px;">Aksi</th></tr>
        </thead>
        <tbody>
            @forelse ($destinations as $destination)
                <tr>
                    <td>
                        @if ($destination->photo)
                            <img src="{{ asset('storage/' . $destination->photo) }}" alt="{{ $destination->name }}" style="width: 80px; height: 60px; object-fit: cover;">
                        @else
                            <span class="text-muted">Tidak ada foto</span>
                        @endif
                    </td>
                    <td>{{ $destination->name }}</td>
                    <td>{{ $destination->country }} / {{ $destination->city }}</td>
                    <td>{{ $destination->category->name ?? '-' }}</td>
                    <td>{{ $destination->latitude }}, {{ $destination->longitude }}</td>
                    <td>{{ $destination->entrance_fee !== null ? number_format($destination->entrance_fee, 0, ',', '.') : '-' }}</td>
                    <td>
                        <a href="{{ route('admin.destinations.edit', $destination) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="{{ route('admin.destinations.destroy', $destination) }}" class="d-inline" onsubmit="return confirm('Hapus destinasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">Belum ada destinasi.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
