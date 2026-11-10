<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    private array $currencies = ['IDR', 'JPY', 'USD', 'KRW', 'MYR', 'SGD'];

    private array $timezones = [
        'Asia/Jakarta', 'Asia/Makassar', 'Asia/Jayapura', 'Asia/Singapore',
        'Asia/Kuala_Lumpur', 'Asia/Bangkok', 'Asia/Tokyo', 'Asia/Seoul', 'UTC',
    ];

    private array $statuses = [
        'draft' => 'Rancangan',
        'planned' => 'Terjadwal',
        'done' => 'Selesai',
    ];

    private array $budgetCategories = [
        'transportasi' => 'Transportasi',
        'penginapan' => 'Penginapan',
        'makanan' => 'Makanan & Minuman',
        'tiket' => 'Tiket Masuk',
        'belanja' => 'Belanja',
        'lainnya' => 'Lainnya',
    ];

    public function index(Request $request)
    {
        $trips = $request->user()->trips()->withCount('details')->latest()->get();
        $statuses = $this->statuses;

        return view('trips.index', compact('trips', 'statuses'));
    }

    public function create()
    {
        return view('trips.create', [
            'trip' => new Trip(),
            'currencies' => $this->currencies,
            'timezones' => $this->timezones,
            'statuses' => $this->statuses,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateTrip($request);

        $trip = $request->user()->trips()->create($validated);

        return redirect()->route('trips.show', $trip)->with('success', __('Itinerary berhasil dibuat. Sekarang tambahkan destinasinya.'));
    }

    public function show(Request $request, Trip $trip)
    {
        $trip = $this->ownTrip($request, $trip);

        $trip->load([
            'details' => fn ($query) => $query->orderBy('sort_order'),
            'details.destination',
            'budgets' => fn ($query) => $query->orderBy('category')->orderBy('name'),
        ]);

        $destinations = Destination::orderBy('country')->orderBy('name')->get();
        $statuses = $this->statuses;
        $budgetCategories = $this->budgetCategories;
        $currencies = $this->currencies;
        $budgetTotals = $trip->budgets->groupBy('currency')->map(fn ($items) => $items->sum('amount'));

        return view('trips.show', compact('trip', 'destinations', 'statuses', 'budgetCategories', 'currencies', 'budgetTotals'));
    }

    public function edit(Request $request, Trip $trip)
    {
        $trip = $this->ownTrip($request, $trip);

        return view('trips.edit', [
            'trip' => $trip,
            'currencies' => $this->currencies,
            'timezones' => $this->timezones,
            'statuses' => $this->statuses,
        ]);
    }

    public function update(Request $request, Trip $trip)
    {
        $trip = $this->ownTrip($request, $trip);
        $trip->update($this->validateTrip($request));

        return redirect()->route('trips.show', $trip)->with('success', __('Itinerary berhasil diperbarui.'));
    }

    public function destroy(Request $request, Trip $trip)
    {
        $trip = $this->ownTrip($request, $trip);

        // Detail itinerary dan anggaran ikut terhapus otomatis
        // lewat foreign key cascadeOnDelete di database.
        $trip->delete();

        return redirect()->route('trips.index')->with('success', __('Itinerary berhasil dihapus.'));
    }

    private function validateTrip(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'destination_country' => ['nullable', 'string', 'max:100'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'currency' => ['required', 'in:' . implode(',', $this->currencies)],
            'timezone' => ['required', 'in:' . implode(',', $this->timezones)],
            'status' => ['required', 'in:' . implode(',', array_keys($this->statuses))],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);
    }

    private function ownTrip(Request $request, Trip $trip): Trip
    {
        abort_unless($trip->user_id === $request->user()->id, 404);

        return $trip;
    }
}
