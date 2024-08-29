<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetRequest;
use App\Models\Category;
use App\Models\Transaction;
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

        // Check if the logged-in user is an admin
        if (auth()->user()->isAdmin()) {
            // Admin can see all transactions
            $recentTransactions = Transaction::with(['user', 'asset'])
                ->orderBy('transaction_date', 'desc')
                ->paginate(3); // Limit to 3 for display on homepage
        } else {
            // Non-admin users can only see their own transactions
            $recentTransactions = Transaction::with(['asset'])
                ->where('user_id', auth()->id())
                ->orderBy('transaction_date', 'desc')
                ->paginate(3); // Limit to 3 for display on homepage
        }

        return view('home', compact('totalAssets', 'availableAssets', 'unavailableAssets',
            'damagedAssets', 'categoryNames', 'assetCounts', 'pendingRequests', 'lowStockAssets','recentTransactions'));
    }


}
