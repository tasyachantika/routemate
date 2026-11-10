<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\TripBudget;
use Illuminate\Http\Request;

class TripBudgetController extends Controller
{
    private array $categories = [
        'transportasi' => 'Transportasi',
        'penginapan' => 'Penginapan',
        'makanan' => 'Makanan & Minuman',
        'tiket' => 'Tiket Masuk',
        'belanja' => 'Belanja',
        'lainnya' => 'Lainnya',
    ];

    private array $currencies = ['IDR', 'JPY', 'USD', 'KRW', 'MYR', 'SGD'];

    public function store(Request $request, Trip $trip)
    {
        $this->ownTrip($request, $trip);

        $trip->budgets()->create($this->validateBudget($request));

        return back()->with('success', 'Item anggaran ditambahkan.');
    }

    public function update(Request $request, Trip $trip, TripBudget $budget)
    {
        $this->ownBudget($request, $trip, $budget);

        $budget->update($this->validateBudget($request));

        return back()->with('success', 'Item anggaran diperbarui.');
    }

    public function destroy(Request $request, Trip $trip, TripBudget $budget)
    {
        $this->ownBudget($request, $trip, $budget);

        $budget->delete();

        return back()->with('success', 'Item anggaran dihapus.');
    }

    private function validateBudget(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'category' => ['required', 'in:' . implode(',', array_keys($this->categories))],
            'amount' => ['required', 'numeric', 'min:0', 'max:999999999999'],
            'currency' => ['required', 'in:' . implode(',', $this->currencies)],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);
    }

    private function ownTrip(Request $request, Trip $trip): Trip
    {
        abort_unless($trip->user_id === $request->user()->id, 404);

        return $trip;
    }

    /**
     * Pemeriksaan dua lapis anti-IDOR: trip harus milik pengguna yang
     * login DAN item anggaran harus benar-benar anak dari trip itu.
     * Pelanggaran dibalas 404 agar keberadaan data orang lain tidak bocor.
     */
    private function ownBudget(Request $request, Trip $trip, TripBudget $budget): void
    {
        $this->ownTrip($request, $trip);

        abort_unless($budget->trip_id === $trip->id, 404);
    }
}
