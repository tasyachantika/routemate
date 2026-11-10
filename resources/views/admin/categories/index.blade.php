@extends('layouts.admin')

@section('title', __('Kategori') . ' - Admin RouteMate')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">{{ __('Kelola Kategori') }}</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">{{ __('Tambah Kategori') }}</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr><th>{{ __('Nama') }}</th><th>{{ __('Deskripsi') }}</th><th>{{ __('Jumlah Destinasi') }}</th><th style="width: 180px;">{{ __('Aksi') }}</th></tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>{{ $category->destinations_count }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="d-inline" onsubmit="return confirm('{{ __("Hapus kategori ini?") }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">{{ __('Hapus') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">{{ __('Belum ada kategori.') }}</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
