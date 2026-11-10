<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\Category;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::with('category')->orderBy('country')->orderBy('name')->get();

        return view('admin.destinations.index', compact('destinations'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $destination = new Destination();

        return view('admin.destinations.create', compact('categories', 'destination'));
    }

    public function store(Request $request)
    {
        $data = $this->validateDestination($request);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('destinations', 'public');
        } else {
            unset($data['photo']);
        }

        $destination = Destination::create($data);

        AdminActivityLog::record('buat', 'Destinasi', $destination->name . ' (' . $destination->city . ', ' . $destination->country . ')');

        return redirect()->route('admin.destinations.index')->with('success', 'Destinasi berhasil ditambahkan.');
    }

    public function edit(Destination $destination)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.destinations.edit', compact('categories', 'destination'));
    }

    public function update(Request $request, Destination $destination)
    {
        $data = $this->validateDestination($request);

        if ($request->hasFile('photo')) {
            if ($destination->photo) {
                Storage::disk('public')->delete($destination->photo);
            }
            $data['photo'] = $request->file('photo')->store('destinations', 'public');
        } else {
            unset($data['photo']);
        }

        $destination->update($data);

        AdminActivityLog::record('ubah', 'Destinasi', $destination->name . ' (' . $destination->city . ', ' . $destination->country . ')');

        return redirect()->route('admin.destinations.index')->with('success', 'Destinasi berhasil diperbarui.');
    }

    public function destroy(Destination $destination)
    {
        AdminActivityLog::record('hapus', 'Destinasi', $destination->name . ' (' . $destination->city . ', ' . $destination->country . ')');

        if ($destination->photo) {
            Storage::disk('public')->delete($destination->photo);
        }

        $destination->delete();

        return redirect()->route('admin.destinations.index')->with('success', 'Destinasi berhasil dihapus.');
    }

    private function validateDestination(Request $request): array
    {
        return $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'address' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'entrance_fee' => ['nullable', 'numeric', 'min:0'],
        ]);
    }
}
