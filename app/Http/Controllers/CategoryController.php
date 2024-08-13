<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created category in the database.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create a new category
        Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Redirect with success message
        return redirect()->route('category.create')->with('success', 'Category created successfully!');
    }

    // Show all categories
    public function index()
    {
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }

    // Show the form for editing a specific category
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    // Update the specific category in the database
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('category.index')->with('success', 'Category updated successfully!');
    }

    // Delete the specific category from the database
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
    }
}
