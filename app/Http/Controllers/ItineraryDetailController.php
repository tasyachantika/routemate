<?php

namespace App\Http\Controllers;

use App\Models\ItineraryDetail;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItineraryDetailController extends Controller
{
    public function store(Request $request, Trip $trip)
    {
        $this->ownTrip($request, $trip);

        $validated = $request->validate([
            'destination_id' => ['required', 'integer', 'exists:destinations,id'],
            'visit_date' => ['nullable', 'date'],
            'visit_time' => ['nullable', 'date_format:H:i'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        if ($trip->details()->where('destination_id', $validated['destination_id'])->exists()) {
            return back()->withErrors(['destination_id' => 'Destinasi ini sudah ada di itinerary ini.'])->withInput();
        }

        if ($error = $this->dateRangeError($trip, $validated['visit_date'] ?? null)) {
            return back()->withErrors(['visit_date' => $error])->withInput();
        }

        $trip->details()->create([
            'destination_id' => $validated['destination_id'],
            'visit_date' => $validated['visit_date'] ?? null,
            'visit_time' => $validated['visit_time'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'sort_order' => (int) $trip->details()->max('sort_order') + 1,
        ]);

        return back()->with('success', 'Destinasi ditambahkan ke itinerary.');
    }

    public function update(Request $request, Trip $trip, ItineraryDetail $detail)
    {
        $this->ownDetail($request, $trip, $detail);

        $validated = $request->validate([
            'visit_date' => ['nullable', 'date'],
            'visit_time' => ['nullable', 'date_format:H:i'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        if ($error = $this->dateRangeError($trip, $validated['visit_date'] ?? null)) {
            return back()->withErrors(['visit_date' => $error])->withInput();
        }

        $detail->update($validated);

        return back()->with('success', 'Jadwal kunjungan diperbarui.');
    }

    public function destroy(Request $request, Trip $trip, ItineraryDetail $detail)
    {
        $this->ownDetail($request, $trip, $detail);
        $detail->delete();
        $this->renumber($trip);

        return back()->with('success', 'Destinasi dihapus dari itinerary.');
    }

    public function move(Request $request, Trip $trip, ItineraryDetail $detail)
    {
        $this->ownDetail($request, $trip, $detail);

        $validated = $request->validate([
            'direction' => ['required', 'in:up,down'],
        ]);

        $details = $trip->details()->orderBy('sort_order')->get()->values();
        $index = $details->search(fn ($item) => $item->id === $detail->id);
        $target = $validated['direction'] === 'up' ? $index - 1 : $index + 1;

        if ($index === false || $target < 0 || $target >= $details->count()) {
            return back();
        }

        $details->splice($index, 1);
        $details->splice($target, 0, [$detail]);

        DB::transaction(function () use ($details) {
            foreach ($details as $position => $item) {
                $item->update(['sort_order' => $position + 1]);
            }
        });

        return back();
    }

    private function ownTrip(Request $request, Trip $trip): void
    {
        abort_unless($trip->user_id === $request->user()->id, 404);
    }

    private function ownDetail(Request $request, Trip $trip, ItineraryDetail $detail): void
    {
        $this->ownTrip($request, $trip);
        abort_unless($detail->trip_id === $trip->id, 404);
    }

    private function dateRangeError(Trip $trip, ?string $visitDate): ?string
    {
        if (! $visitDate || ! $trip->start_date || ! $trip->end_date) {
            return null;
        }

        $start = substr((string) $trip->start_date, 0, 10);
        $end = substr((string) $trip->end_date, 0, 10);

        return ($visitDate < $start || $visitDate > $end)
            ? 'Tanggal kunjungan harus berada di antara tanggal mulai dan tanggal selesai trip.'
            : null;
    }

    private function renumber(Trip $trip): void
    {
        $details = $trip->details()->orderBy('sort_order')->get();

        DB::transaction(function () use ($details) {
            foreach ($details as $position => $item) {
                $item->update(['sort_order' => $position + 1]);
            }
        });
    }
}
