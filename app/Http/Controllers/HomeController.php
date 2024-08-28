<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        // Calculate the totals
        $totalAssets = Asset::count();
        $availableAssets = Asset::where('status', 'available')->count();
        $unavailableAssets = Asset::where('status', 'unavailable')->count();
        $damagedAssets = Asset::where('status', 'damaged')->count();

        // Fetch category names and asset counts for the bar chart
        $categories = Category::withCount('assets')->get();
        $categoryNames = $categories->pluck('name');
        $assetCounts = $categories->pluck('assets_count');

        // Get the number of pending requests
        $pendingRequests = AssetRequest::where('status', 'pending')->count();

        // Get the low stock assets
        $lowStockAssets = Asset::where('quantity', '<', 3)->get();

        return view('home', compact('totalAssets', 'availableAssets', 'unavailableAssets',
            'damagedAssets', 'categoryNames', 'assetCounts', 'pendingRequests', 'lowStockAssets'));
    }


}
