<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'name' => 'required|string|max:255|unique:categories,name',
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
        $categories = Category::paginate(10);
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
        // Validate the request data
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                // Ensure the name is unique except for the current category
                Rule::unique('categories', 'name')->ignore($category->id),
            ],
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
