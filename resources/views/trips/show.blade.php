@extends('layouts.app')

@section('title', $trip->title . ' - RouteMate')

@section('content')
    <a href="{{ route('trips.index') }}" class="btn btn-outline-secondary mb-3">&larr; Kembali ke Itinerary Saya</a>

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
            <span class="badge bg-secondary">{{ $statuses[$trip->status] ?? $trip->status }}</span>
            <h1 class="mt-2">{{ $trip->title }}</h1>
            <p class="text-muted mb-1">{{ $trip->destination_country ?? 'Negara tujuan belum diisi' }}</p>
            <p class="mb-1">Tanggal: {{ $trip->start_date ? substr((string) $trip->start_date, 0, 10) : '...' }} s/d {{ $trip->end_date ? substr((string) $trip->end_date, 0, 10) : '...' }}</p>
            <p class="mb-1">Mata uang anggaran: <strong>{{ $trip->currency }}</strong> &middot; Zona waktu: <strong>{{ $trip->timezone }}</strong></p>
            @if ($trip->notes)
                <p class="mb-0">Catatan: {{ $trip->notes }}</p>
            @endif
            <a href="{{ route('trips.edit', $trip) }}" class="btn btn-outline-secondary btn-sm mt-3">Edit Info Trip</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header fw-bold">Tambah Destinasi ke Itinerary Ini</div>
        <div class="card-body">
            <form method="POST" action="{{ route('trips.details.store', $trip) }}" class="row g-2">
                @csrf
                <div class="col-md-4">
                    <select name="destination_id" class="form-select" required>
                        <option value="">-- Pilih Destinasi --</option>
                        @foreach ($destinations as $destination)
                            <option value="{{ $destination->id }}" @selected((string) old('destination_id') === (string) $destination->id)>{{ $destination->name }} ({{ $destination->city }}, {{ $destination->country }})</option>
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
                    <input type="text" name="notes" class="form-control" maxlength="500" placeholder="Catatan" value="{{ old('notes') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <h2 class="h4 mb-3">Urutan Kunjungan</h2>
    @forelse ($trip->details as $detail)
        <div class="card mb-2">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="mb-1"><span class="badge bg-primary me-2">{{ $detail->sort_order }}</span><a href="{{ route('destinations.show', $detail->destination) }}">{{ $detail->destination->name }}</a></h5>
                        <h2 class="h4 mt-4 mb-3">Anggaran Perjalanan</h2>

<div class="card mb-3">
    <div class="card-header fw-bold">Tambah Item Anggaran</div>
    <div class="card-body">
        <form method="POST" action="{{ route('trips.budgets.store', $trip) }}" class="row g-2">
            @csrf
            <div class="col-md-3">
                <input type="text" name="name" class="form-control" maxlength="150" placeholder="Nama biaya, cth: Hotel 4 malam" value="{{ old('name') }}" required>
            </div>
            <div class="col-md-2">
                <select name="category" class="form-select" required>
                    @foreach ($budgetCategories as $value => $label)
                        <option value="{{ $value }}" @selected(old('category') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="amount" class="form-control" min="0" step="0.01" placeholder="Jumlah" value="{{ old('amount') }}" required>
            </div>
            <div class="col-md-2">
                <select name="currency" class="form-select" required>
                    @foreach ($currencies as $currency)
                        <option value="{{ $currency }}" @selected(old('currency', $trip->currency) === $currency)>{{ $currency }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="text" name="notes" class="form-control" maxlength="500" placeholder="Catatan" value="{{ old('notes') }}">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Tambah</button>
            </div>
        </form>
    </div>
</div>

@if ($trip->budgets->isEmpty())
    <div class="alert alert-info">Belum ada item anggaran untuk trip ini.</div>
@else
    <div class="card mb-3">
        <div class="table-responsive">
            <table class="table table-striped mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Nama Biaya</th>
                        <th>Kategori</th>
                        <th class="text-end">Jumlah</th>
                        <th>Catatan</th>
                        <th style="width: 170px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trip->budgets as $budget)
                        <tr>
                            <td>{{ $budget->name }}</td>
                            <td>{{ $budgetCategories[$budget->category] ?? $budget->category }}</td>
                            <td class="text-end">{{ $budget->currency }} {{ number_format((float) $budget->amount, 2, ',', '.') }}</td>
                            <td>{{ $budget->notes ?? '-' }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#anggaran-{{ $budget->id }}">Edit</button>
                                    <form method="POST" action="{{ route('trips.budgets.destroy', [$trip, $budget]) }}" onsubmit="return confirm('Hapus item anggaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
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
                                                <option value="{{ $value }}" @selected($budget->category === $value)>{{ $label }}</option>
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
                                        <input type="text" name="notes" class="form-control" maxlength="500" value="{{ $budget->notes }}" placeholder="Catatan">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-primary w-100">Simpan</button>
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
            <h3 class="h6">Total Anggaran per Mata Uang</h3>
            <ul class="list-unstyled mb-0">
                @foreach ($budgetTotals as $currency => $total)
                    <li class="fs-5">Total {{ $currency }}: <strong>{{ number_format((float) $total, 2, ',', '.') }}</strong></li>
                @endforeach
            </ul>
            <p class="text-muted mb-0 mt-2">Total ditampilkan terpisah per mata uang karena versi ini tidak melakukan konversi kurs secara otomatis.</p>
        </div>
    </div>
@endif

                        <p class="mb-1">Kunjungan: {{ $detail->visit_date ? substr((string) $detail->visit_date, 0, 10) : 'tanggal belum diatur' }} {{ $detail->visit_time ? substr((string) $detail->visit_time, 0, 5) : '' }} ({{ $trip->timezone }})</p>
                        @if ($detail->notes)
                            <p class="mb-0">Catatan: {{ $detail->notes }}</p>
                        @endif
                    </div>
                    <div class="d-flex flex-column gap-1">
                        <form method="POST" action="{{ route('trips.details.move', [$trip, $detail]) }}">
                            @csrf
                            <input type="hidden" name="direction" value="up">
                            <button type="submit" class="btn btn-sm btn-outline-secondary w-100">Naik</button>
                        </form>
                        <form method="POST" action="{{ route('trips.details.move', [$trip, $detail]) }}">
                            @csrf
                            <input type="hidden" name="direction" value="down">
                            <button type="submit" class="btn btn-sm btn-outline-secondary w-100">Turun</button>
                        </form>
                        <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#jadwal-{{ $detail->id }}">Atur Jadwal</button>
                        <form method="POST" action="{{ route('trips.details.destroy', [$trip, $detail]) }}" onsubmit="return confirm('Hapus destinasi ini dari itinerary?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger w-100">Hapus</button>
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
                            <input type="text" name="notes" class="form-control" maxlength="500" value="{{ $detail->notes }}" placeholder="Catatan">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Simpan Jadwal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">Itinerary ini masih kosong. Tambahkan destinasi pertama lewat formulir di atas, atau dari halaman detail destinasi.</div>
    @endforelse

    <p class="text-muted mt-3">Bagian anggaran perjalanan (transportasi, penginapan, makanan, dan lain-lain) ditambahkan pada Tahap 13.</p>
@endsection
