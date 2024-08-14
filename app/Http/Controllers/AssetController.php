<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetRequest;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::with(['location', 'category'])->get();
        return view('asset.index', compact('assets'));
    }

    public function create()
    {
        $locations = Location::all();
        $categories = Category::all();
        return view('asset.create', compact('locations', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'status' => 'required|in:available,in use,damaged',
            'description' => 'nullable|string',
        ]);

        Asset::create($request->all());

        return redirect()->route('asset.create')->with('success', 'Asset created successfully!');
    }

    public function edit(Asset $asset)
    {
        $locations = Location::all();
        $categories = Category::all();
        return view('asset.edit', compact('asset', 'locations', 'categories'));
    }

    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'status' => 'required|in:available,in use,damaged',
            'description' => 'nullable|string',
        ]);

        $asset->update($request->all());

        return redirect()->route('asset.index')->with('success', 'Asset updated successfully!');
    }
}
