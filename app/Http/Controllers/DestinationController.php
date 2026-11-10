<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
        ]);

        $destinations = Destination::with('category')
            ->when($filters['q'] ?? null, function ($query, $q) {
                $like = '%' . str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $q) . '%';
                $query->where(function ($sub) use ($like) {
                    $sub->where('name', 'like', $like)
                        ->orWhere('city', 'like', $like)
                        ->orWhere('country', 'like', $like);
                });
            })
            ->when($filters['country'] ?? null, function ($query, $country) {
                $query->where('country', $country);
            })
            ->when($filters['category_id'] ?? null, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->orderBy('country')
            ->orderBy('name')
            ->get();

        $countries = Destination::query()->distinct()->orderBy('country')->pluck('country');
        $categories = Category::orderBy('name')->get();

        return view('destinations.index', compact('destinations', 'countries', 'categories', 'filters'));
    }

    public function show(Request $request, Destination $destination)
    {
        $destination->load('category');
        $userTrips = $request->user()->trips()->latest()->get();

        return view('destinations.show', compact('destination', 'userTrips'));
    }
}
