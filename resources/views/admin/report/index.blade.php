@extends('layouts.admin')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">{{ __('Laporan & Statistik') }}</h1>
        <p class="text-muted mb-0">{{ __('Rekap data RouteMate: destinasi, negara, kategori, pengguna, itinerary, dan anggaran.') }}</p>
    </div>
    <a href="{{ route('admin.report.export') }}" class="btn btn-success">{{ __('Unduh CSV Destinasi Terpopuler') }}</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card text-center h-100"><div class="card-body">
            <div class="display-6">{{ $stats['destinations'] }}</div>
            <div class="text-muted small">{{ __('Destinasi') }}</div>
        </div></div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card text-center h-100"><div class="card-body">
            <div class="display-6">{{ $stats['countries'] }}</div>
            <div class="text-muted small">{{ __('Negara') }}</div>
        </div></div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card text-center h-100"><div class="card-body">
            <div class="display-6">{{ $stats['categories'] }}</div>
            <div class="text-muted small">{{ __('Kategori') }}</div>
        </div></div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card text-center h-100"><div class="card-body">
            <div class="display-6">{{ $stats['users'] }}</div>
            <div class="text-muted small">{{ __('Pengguna') }}</div>
        </div></div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card text-center h-100"><div class="card-body">
            <div class="display-6">{{ $stats['trips'] }}</div>
            <div class="text-muted small">{{ __('Trip / Itinerary') }}</div>
        </div></div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card text-center h-100"><div class="card-body">
            <div class="display-6">{{ $stats['itinerary_items'] }}</div>
            <div class="text-muted small">{{ __('Item Itinerary') }}</div>
        </div></div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header fw-semibold">{{ __('Jumlah Destinasi per Negara') }}</div>
    <div class="card-body">
        @forelse ($perCountry as $row)
            <div class="d-flex align-items-center mb-2">
                <div style="width: 170px" class="text-truncate small">{{ $row->country }}</div>
                <div class="progress flex-grow-1 mx-2" role="progressbar" aria-label="{{ __('Jumlah destinasi') }} {{ $row->country }}">
                    <div class="progress-bar" style="width: {{ round($row->total / $maxCountry * 100) }}%"></div>
                </div>
                <div style="width: 40px" class="text-end fw-semibold">{{ $row->total }}</div>
            </div>
        @empty
            <p class="text-muted mb-0">{{ __('Belum ada data destinasi.') }}</p>
        @endforelse
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header fw-semibold">{{ __('Destinasi Terpopuler di Itinerary Pengguna') }}</div>
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px">#</th>
                            <th>{{ __('Destinasi') }}</th>
                            <th>{{ __('Lokasi') }}</th>
                            <th>{{ __('Kategori') }}</th>
                            <th class="text-end">{{ __('Di Itinerary') }}</th>
                            <th class="text-end">{{ __('Jumlah Trip') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($popular as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $row->name }}</td>
                                <td>{{ $row->city }}, {{ $row->country }}</td>
                                <td>{{ $row->category_name ?? __('Tanpa Kategori') }}</td>
                                <td class="text-end">{{ $row->itinerary_count }}</td>
                                <td class="text-end">{{ $row->trip_count }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted">{{ __('Belum ada data destinasi.') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-muted small">
                {{ __('Peringkat dihitung dari berapa kali destinasi dimasukkan pengguna ke itinerary mereka. Angka bertambah seiring penggunaan aplikasi.') }}
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header fw-semibold">{{ __('Destinasi per Kategori') }}</div>
            <ul class="list-group list-group-flush">
                @forelse ($perCategory as $row)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $row->category_name }}
                        <span class="badge bg-primary rounded-pill">{{ $row->total }}</span>
                    </li>
                @empty
                    <li class="list-group-item text-muted">{{ __('Belum ada data.') }}</li>
                @endforelse
            </ul>
        </div>
        <div class="card">
            <div class="card-header fw-semibold">{{ __('Anggaran Tercatat per Mata Uang') }}</div>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead>
                        <tr><th>{{ __('Mata Uang') }}</th><th class="text-end">{{ __('Item') }}</th><th class="text-end">Total</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($budgetPerCurrency as $row)
                            <tr>
                                <td class="fw-semibold">{{ $row->currency }}</td>
                                <td class="text-end">{{ $row->items }}</td>
                                <td class="text-end">{{ \App\Support\Money::format((float) $row->total, $row->currency) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">{{ __('Belum ada anggaran tercatat.') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-muted small">
                {{ __('Total dipisah per mata uang karena RouteMate v1 tidak melakukan konversi kurs.') }}
            </div>
        </div>
    </div>
</div>
@endsection
