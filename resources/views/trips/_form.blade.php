@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label class="form-label">{{ __('Judul Itinerary') }}</label>
    <input type="text" name="title" class="form-control" maxlength="150" value="{{ old('title', $trip->title) }}" required>
</div>
<div class="mb-3">
    <label class="form-label">{{ __('Negara Tujuan Utama') }}</label>
    <input type="text" name="destination_country" class="form-control" maxlength="100" value="{{ old('destination_country', $trip->destination_country) }}">
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('Tanggal Mulai') }}</label>
        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $trip->start_date ? substr((string) $trip->start_date, 0, 10) : '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('Tanggal Selesai') }}</label>
        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $trip->end_date ? substr((string) $trip->end_date, 0, 10) : '') }}">
    </div>
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">{{ __('Mata Uang Anggaran') }}</label>
        <select name="currency" class="form-select" required>
            @foreach ($currencies as $currency)
                <option value="{{ $currency }}" @selected(old('currency', $trip->currency ?? 'IDR') === $currency)>{{ $currency }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">{{ __('Zona Waktu') }}</label>
        <select name="timezone" class="form-select" required>
            @foreach ($timezones as $timezone)
                <option value="{{ $timezone }}" @selected(old('timezone', $trip->timezone ?? 'Asia/Jakarta') === $timezone)>{{ $timezone }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            @foreach ($statuses as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $trip->status ?? 'draft') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">{{ __('Catatan') }}</label>
    <textarea name="notes" class="form-control" rows="3" maxlength="1000">{{ old('notes', $trip->notes) }}</textarea>
</div>
