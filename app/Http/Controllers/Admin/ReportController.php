<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Destination;
use App\Models\ItineraryDetail;
use App\Models\Trip;
use App\Models\TripBudget;
use App\Models\User;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'destinations' => Destination::count(),
            'countries' => Destination::distinct()->count('country'),
            'categories' => Category::count(),
            'users' => User::count(),
            'trips' => Trip::count(),
            'itinerary_items' => ItineraryDetail::count(),
        ];

        $popular = $this->popularDestinations();

        $perCountry = Destination::query()
            ->selectRaw('country, COUNT(*) as total')
            ->groupBy('country')
            ->orderByDesc('total')
            ->get();
        $maxCountry = max(1, (int) ($perCountry->max('total') ?? 1));

        $perCategory = Destination::query()
            ->leftJoin('categories', 'categories.id', '=', 'destinations.category_id')
            ->selectRaw("COALESCE(categories.name, 'Tanpa Kategori') as category_name, COUNT(*) as total")
            ->groupBy('category_name')
            ->orderByDesc('total')
            ->get();

        $budgetPerCurrency = TripBudget::query()
            ->selectRaw('currency, COUNT(*) as items, SUM(amount) as total')
            ->groupBy('currency')
            ->orderBy('currency')
            ->get();

        return view('admin.report.index', compact(
            'stats', 'popular', 'perCountry', 'maxCountry', 'perCategory', 'budgetPerCurrency'
        ));
    }

    public function export(): StreamedResponse
    {
        $rows = $this->popularDestinations();

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Peringkat', 'Destinasi', 'Kota', 'Negara', 'Kategori', 'Jumlah Itinerary', 'Jumlah Trip']);
            foreach ($rows as $i => $row) {
                fputcsv($out, [
                    $i + 1,
                    $row->name,
                    $row->city,
                    $row->country,
                    $row->category_name ?? 'Tanpa Kategori',
                    $row->itinerary_count,
                    $row->trip_count,
                ]);
            }
            fclose($out);
        }, 'laporan-destinasi-terpopuler.csv', ['Content-Type' => 'text/csv']);
    }

    private function popularDestinations()
    {
        return Destination::query()
            ->leftJoin('itinerary_details', 'itinerary_details.destination_id', '=', 'destinations.id')
            ->leftJoin('categories', 'categories.id', '=', 'destinations.category_id')
            ->select('destinations.name', 'destinations.city', 'destinations.country', 'categories.name as category_name')
            ->selectRaw('COUNT(itinerary_details.id) as itinerary_count')
            ->selectRaw('COUNT(DISTINCT itinerary_details.trip_id) as trip_count')
            ->groupBy('destinations.id', 'destinations.name', 'destinations.city', 'destinations.country', 'categories.name')
            ->orderByDesc('itinerary_count')
            ->orderBy('destinations.name')
            ->get();
    }
}
