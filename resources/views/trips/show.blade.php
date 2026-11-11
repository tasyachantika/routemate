@extends('layouts.app')

@section('title', $trip->title . ' - RouteMate')

@section('content')
<div class="container pb-5">
    <a href="{{ route('trips.index') }}" class="btn btn-outline-secondary mb-3">&larr; {{ __('Kembali ke Itinerary Saya') }}</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <span class="badge bg-secondary">{{ __($statuses[$trip->status] ?? $trip->status) }}</span>
            <h1 class="mt-2">{{ $trip->title }}</h1>
            <p class="text-muted mb-1">{{ $trip->destination_country ?? __('Negara tujuan belum diisi') }}</p>
            <p class="mb-1">{{ __('Tanggal:') }} {{ $trip->start_date ? \Carbon\Carbon::parse($trip->start_date)->translatedFormat('d F Y') : '...' }} {{ __('s/d') }} {{ $trip->end_date ? \Carbon\Carbon::parse($trip->end_date)->translatedFormat('d F Y') : '...' }}</p>
            <p class="mb-1">{{ __('Mata uang anggaran:') }} <strong>{{ $trip->currency }}</strong> &middot; {{ __('Zona waktu:') }} <strong>{{ $trip->timezone }}</strong></p>
            <p class="text-muted small mb-0">{{ __('Semua jam kunjungan pada itinerary ini memakai waktu setempat di tujuan, sesuai zona waktu di atas — bukan waktu Indonesia.') }}</p>
            @if ($trip->notes)
                <p class="mb-0 mt-2">{{ __('Catatan:') }} {{ $trip->notes }}</p>
            @endif
            <a href="{{ route('trips.edit', $trip) }}" class="btn btn-outline-secondary btn-sm mt-3">{{ __('Edit Info Trip') }}</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header fw-bold">{{ __('Tambah Destinasi ke Itinerary Ini') }}</div>
        <div class="card-body">
            <form method="POST" action="{{ route('trips.details.store', $trip) }}" class="row g-2">
                @csrf
                <div class="col-md-4">
                    <select name="destination_id" class="form-select" required>
                        <option value="">{{ __('-- Pilih Destinasi --') }}</option>
                        @foreach ($destinations as $destination)
                            <option value="{{ $destination->id }}" @selected((string) old('destination_id') === (string) $destination->id)>{{ __($destination->name) }} ({{ $destination->city }}, {{ __($destination->country) }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="visit_date" class="form-control" value="{{ old('visit_date') }}">
                </div>
                <div class="col-md-2">
                    <input type="time" name="visit_time" class="form-control" value="{{ old('visit_time') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" name="notes" class="form-control" maxlength="500" placeholder="{{ __('Catatan') }}" value="{{ old('notes') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">{{ __('Tambah') }}</button>
                </div>
            </form>
        </div>
    </div>

    <h2 class="h4 mb-3">{{ __('Urutan Kunjungan') }}</h2>
    @forelse ($trip->details as $detail)
        <div class="card mb-2">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="mb-1"><span class="badge bg-primary me-2">{{ $detail->sort_order }}</span><a href="{{ route('destinations.show', $detail->destination) }}">{{ __($detail->destination->name) }}</a></h5>
                        <p class="mb-1">{{ __('Kunjungan:') }} {{ $detail->visit_date ? \Carbon\Carbon::parse($detail->visit_date)->translatedFormat('d F Y') : __('tanggal belum diatur') }} {{ $detail->visit_time ? substr((string) $detail->visit_time, 0, 5) : '' }} <span class="text-muted">({{ __('waktu setempat') }}, {{ $trip->timezone }})</span></p>
                        @if ($detail->notes)
                            <p class="mb-0">{{ __('Catatan:') }} {{ $detail->notes }}</p>
                        @endif
                    </div>
                    <div class="d-flex flex-column gap-1">
                        <form method="POST" action="{{ route('trips.details.move', [$trip, $detail]) }}">
                            @csrf
                            <input type="hidden" name="direction" value="up">
                            <button type="submit" class="btn btn-sm btn-outline-secondary w-100">{{ __('Naik') }}</button>
                        </form>
                        <form method="POST" action="{{ route('trips.details.move', [$trip, $detail]) }}">
                            @csrf
                            <input type="hidden" name="direction" value="down">
                            <button type="submit" class="btn btn-sm btn-outline-secondary w-100">{{ __('Turun') }}</button>
                        </form>
                        <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#jadwal-{{ $detail->id }}">{{ __('Atur Jadwal') }}</button>
                        <form method="POST" action="{{ route('trips.details.destroy', [$trip, $detail]) }}" onsubmit="return confirm('{{ __("Hapus destinasi ini dari itinerary?") }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger w-100">{{ __('Hapus') }}</button>
                        </form>
                    </div>
                </div>
                <div class="collapse mt-3" id="jadwal-{{ $detail->id }}">
                    <form method="POST" action="{{ route('trips.details.update', [$trip, $detail]) }}" class="row g-2">
                        @csrf
                        @method('PUT')
                        <div class="col-md-3">
                            <input type="date" name="visit_date" class="form-control" value="{{ $detail->visit_date ? substr((string) $detail->visit_date, 0, 10) : '' }}">
                        </div>
                        <div class="col-md-2">
                            <input type="time" name="visit_time" class="form-control" value="{{ $detail->visit_time ? substr((string) $detail->visit_time, 0, 5) : '' }}">
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="notes" class="form-control" maxlength="500" value="{{ $detail->notes }}" placeholder="{{ __('Catatan') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">{{ __('Simpan Jadwal') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">{{ __('Itinerary ini masih kosong. Tambahkan destinasi pertama lewat formulir di atas, atau dari halaman detail destinasi.') }}</div>
    @endforelse

    <h2 class="h4 mt-5 mb-3">{{ __('Anggaran Perjalanan') }}</h2>

    <div class="card mb-3">
        <div class="card-header fw-bold">{{ __('Tambah Item Anggaran') }}</div>
        <div class="card-body">
            <form method="POST" action="{{ route('trips.budgets.store', $trip) }}" class="row g-2">
                @csrf
                <div class="col-md-3">
                    <input type="text" name="name" class="form-control" maxlength="150" placeholder="{{ __('Nama biaya, cth: Hotel 4 malam') }}" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-2">
                    <select name="category" class="form-select" required>
                        @foreach ($budgetCategories as $value => $label)
                            <option value="{{ $value }}" @selected(old('category') === $value)>{{ __($label) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="amount" class="form-control" min="0" step="0.01" placeholder="{{ __('Jumlah') }}" value="{{ old('amount') }}" required>
                </div>
                <div class="col-md-2">
                    <select name="currency" class="form-select" required>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency }}" @selected(old('currency', $trip->currency) === $currency)>{{ $currency }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="text" name="notes" class="form-control" maxlength="500" placeholder="{{ __('Catatan') }}" value="{{ old('notes') }}">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">{{ __('Tambah') }}</button>
                </div>
            </form>
        </div>
    </div>

    @if ($trip->budgets->isEmpty())
        <div class="alert alert-info">{{ __('Belum ada item anggaran untuk trip ini.') }}</div>
    @else
        <div class="card mb-3">
            <div class="table-responsive">
                <table class="table table-striped mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>{{ __('Nama Biaya') }}</th>
                            <th>{{ __('Kategori') }}</th>
                            <th class="text-end">{{ __('Jumlah') }}</th>
                            <th>{{ __('Catatan') }}</th>
                            <th style="width: 170px;">{{ __('Aksi') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trip->budgets as $budget)
                            <tr>
                                <td>{{ $budget->name }}</td>
                                <td>{{ __($budgetCategories[$budget->category] ?? $budget->category) }}</td>
                                <td class="text-end">{{ \App\Support\Money::format((float) $budget->amount, $budget->currency) }}</td>
                                <td>{{ $budget->notes ?? '-' }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#anggaran-{{ $budget->id }}">{{ __('Edit') }}</button>
                                        <form method="POST" action="{{ route('trips.budgets.destroy', [$trip, $budget]) }}" onsubmit="return confirm('{{ __("Hapus item anggaran ini?") }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Hapus') }}</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <tr class="collapse" id="anggaran-{{ $budget->id }}">
                                <td colspan="5">
                                    <form method="POST" action="{{ route('trips.budgets.update', [$trip, $budget]) }}" class="row g-2">
                                        @csrf
                                        @method('PUT')
                                        <div class="col-md-3">
                                            <input type="text" name="name" class="form-control" maxlength="150" value="{{ $budget->name }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="category" class="form-select" required>
                                                @foreach ($budgetCategories as $value => $label)
                                                    <option value="{{ $value }}" @selected($budget->category === $value)>{{ __($label) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" name="amount" class="form-control" min="0" step="0.01" value="{{ $budget->amount }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="currency" class="form-select" required>
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency }}" @selected($budget->currency === $currency)>{{ $currency }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="notes" class="form-control" maxlength="500" value="{{ $budget->notes }}" placeholder="{{ __('Catatan') }}">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="submit" class="btn btn-primary w-100">{{ __('Simpan') }}</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h3 class="h6">{{ __('Total Anggaran per Mata Uang') }}</h3>
                <ul class="list-unstyled mb-0">
                    @foreach ($budgetTotals as $currency => $total)
                        <li class="fs-5">Total {{ $currency }}: <strong>{{ \App\Support\Money::format((float) $total, $currency) }}</strong></li>
                    @endforeach
                </ul>
                <p class="text-muted mb-0 mt-2">{{ __('Total ditampilkan terpisah per mata uang karena versi ini tidak melakukan konversi kurs secara otomatis — menjumlahkan mata uang yang berbeda akan menyesatkan.') }}</p>
            </div>
        </div>
    @endif
</div>
@endsection
