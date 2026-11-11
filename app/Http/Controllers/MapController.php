<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
        ]);

        $query = Destination::with('category')->orderBy('name');

        if (! empty($validated['q'] ?? null)) {
            $keyword = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $validated['q']);
            $query->where(function ($sub) use ($keyword) {
                $sub->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('city', 'like', '%' . $keyword . '%')
                    ->orWhere('country', 'like', '%' . $keyword . '%');
            });
        }

        if (! empty($validated['country'] ?? null)) {
            $query->where('country', $validated['country']);
        }

        $destinations = $query->get();

        $countries = Destination::query()
            ->distinct()
            ->orderBy('country')
            ->pluck('country');

        $mapDestinations = $destinations->map(function (Destination $destination) {
            return [
                'name' => __($destination->name),
                'city' => $destination->city,
                'country' => __($destination->country),
                'category' => __($destination->category->name ?? 'Tanpa Kategori'),
                'latitude' => (float) $destination->latitude,
                'longitude' => (float) $destination->longitude,
                'detail_url' => route('destinations.show', $destination),
            ];
        })->values();

        return view('map.index', [
            'destinations' => $destinations,
            'mapDestinations' => $mapDestinations,
            'countries' => $countries,
            'q' => $validated['q'] ?? '',
            'country' => $validated['country'] ?? '',
        ]);
    }
}
