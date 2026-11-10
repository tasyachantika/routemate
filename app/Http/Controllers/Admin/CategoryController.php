<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('destinations')->orderBy('name')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:categories,name'],
            'description' => ['nullable', 'string'],
        ]);

        $category = Category::create($validated);

        AdminActivityLog::record('buat', 'Kategori', $category->name);

        return redirect()->route('admin.categories.index')->with('success', __('Kategori berhasil ditambahkan.'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('categories', 'name')->ignore($category->id)],
            'description' => ['nullable', 'string'],
        ]);

        $category->update($validated);

        AdminActivityLog::record('ubah', 'Kategori', $category->name);

        return redirect()->route('admin.categories.index')->with('success', __('Kategori berhasil diperbarui.'));
    }

    public function destroy(Category $category)
    {
        AdminActivityLog::record('hapus', 'Kategori', $category->name);

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', __('Kategori berhasil dihapus. Destinasi yang memakai kategori ini sekarang tidak berkategori.'));
    }
}
