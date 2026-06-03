<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Category::with('parent');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->has('filter') && $request->filter != '') {
            $filter = $request->filter;
            if ($filter == 'main') {
                $query->whereNull('parent_id');
            } else {
                $query->where('parent_id', $filter);
            }
        }

        $categories = $query->get()->sortBy(function($cat) {
            $parentName = $cat->parent_id ? ($cat->parent->name ?? '') : $cat->name;
            $isChild = $cat->parent_id ? 1 : 0;
            return $parentName . '-' . $isChild . '-' . $cat->name;
        })->values();

        $mainCategories = Category::whereNull('parent_id')->orderBy('name')->get();

        return view('categories.index', compact('categories', 'mainCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'parent_id' => 'nullable|exists:categories,id',
            'type_category' => 'nullable|in:hardware,peripheral,software,service',
        ]);

        if (!empty($validated['parent_id'])) {
            $parent = Category::find($validated['parent_id']);
            $validated['type_category'] = $parent->type_category;
        } else {
            $validated['type_category'] = $validated['type_category'] ?? 'hardware';
        }

        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'parent_id' => 'nullable|exists:categories,id',
            'type_category' => 'nullable|in:hardware,peripheral,software,service',
        ]);

        if (!empty($validated['parent_id'])) {
            $parent = Category::find($validated['parent_id']);
            $validated['type_category'] = $parent->type_category;
        } else {
            $validated['type_category'] = $validated['type_category'] ?? $category->type_category;
        }

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'Kategori tidak dapat dihapus karena masih digunakan pada produk.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
