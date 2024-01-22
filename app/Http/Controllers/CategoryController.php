<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('adminsso.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
        ]);

        Category::create($validatedData);

        return  back()->with('success', 'Berhasil tambah kategori');
    }

    public function update(Category $category, Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
        ]);

        $category->update($validatedData);

        return  back()->with('success', 'Berhasil update kategori');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back();
    }
}
