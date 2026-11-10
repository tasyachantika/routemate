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
    <label class="form-label">{{ __('Nama Destinasi') }}</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $destination->name) }}" required>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">{{ __('Negara') }}</label>
        <input type="text" name="country" class="form-control" value="{{ old('country', $destination->country) }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">{{ __('Kota / Wilayah') }}</label>
        <input type="text" name="city" class="form-control" value="{{ old('city', $destination->city) }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">{{ __('Kategori') }}</label>
        <select name="category_id" class="form-select">
            <option value="">{{ __('-- Pilih Kategori --') }}</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected((string) old('category_id', $destination->category_id) === (string) $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">{{ __('Deskripsi') }}</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description', $destination->description) }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">{{ __('Alamat') }}</label>
    <input type="text" name="address" class="form-control" value="{{ old('address', $destination->address) }}">
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Latitude</label>
        <input type="text" name="latitude" id="latitude" class="form-control" value="{{ old('latitude', $destination->latitude) }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Longitude</label>
        <input type="text" name="longitude" id="longitude" class="form-control" value="{{ old('longitude', $destination->longitude) }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">{{ __('Perkiraan Biaya Masuk') }}</label>
        <input type="number" name="entrance_fee" class="form-control" step="0.01" min="0" value="{{ old('entrance_fee', $destination->entrance_fee) }}">
        <div class="form-text">{{ __('Sesuai mata uang negara destinasi. Kosongkan jika gratis / tidak diketahui.') }}</div>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">{{ __('Periksa Lokasi di Peta — klik peta untuk mengisi Latitude & Longitude') }}</label>
    <div id="map" style="height: 320px;"></div>
</div>

<div class="mb-3">
    <label class="form-label">{{ __('Foto Destinasi') }}</label>
    @if ($destination->photo)
        <div class="mb-2">
            <img src="{{ asset('storage/' . $destination->photo) }}" alt="{{ $destination->name }}" style="max-width: 240px;">
            <div class="form-text">{{ __('Foto saat ini. Pilih file baru hanya jika ingin menggantinya.') }}</div>
        </div>
    @endif
    <input type="file" name="photo" class="form-control" accept="image/*">
</div>

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');
        const startLat = parseFloat(latInput.value) || -2.5489;
        const startLng = parseFloat(lngInput.value) || 118.0149;
        const startZoom = latInput.value && lngInput.value ? 13 : 4;

        const map = L.map('map').setView([startLat, startLng], startZoom);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        let marker = null;
        if (latInput.value && lngInput.value) {
            marker = L.marker([startLat, startLng]).addTo(map);
        }

        map.on('click', function (e) {
            latInput.value = e.latlng.lat.toFixed(7);
            lngInput.value = e.latlng.lng.toFixed(7);
            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                marker = L.marker(e.latlng).addTo(map);
            }
        });
    </script>
@endpush
