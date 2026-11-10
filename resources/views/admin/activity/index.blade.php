@extends('layouts.admin')

@section('title', __('Log Aktivitas Admin') . ' - RouteMate')

@section('content')
    <h1 class="mb-3">{{ __('Log Aktivitas Admin') }}</h1>
    <p class="text-muted">{{ __('Catatan otomatis setiap aksi tambah, ubah, dan hapus yang dilakukan admin pada kategori dan destinasi. Berguna untuk audit keamanan.') }}</p>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width: 170px;">{{ __('Waktu') }}</th>
                        <th>Admin</th>
                        <th>{{ __('Aksi') }}</th>
                        <th>{{ __('Objek') }}</th>
                        <th>{{ __('Keterangan') }}</th>
                        <th style="width: 130px;">IP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td>{{ $log->created_at?->locale('id')->translatedFormat('d M Y H:i') }}</td>
                            <td>{{ $log->user->name ?? __('(akun terhapus)') }}</td>
                            <td><span class="badge bg-secondary">{{ $log->action }}</span></td>
                            <td>{{ $log->subject }}</td>
                            <td>{{ $log->description ?? '-' }}</td>
                            <td>{{ $log->ip_address ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">{{ __('Belum ada aktivitas tercatat. Log akan terisi setiap admin menambah, mengubah, atau menghapus kategori/destinasi.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $logs->links() }}
    </div>
@endsection
