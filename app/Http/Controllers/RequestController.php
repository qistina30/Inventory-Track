<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            // Fetch all requests with associated users and assets, ordering by status so that 'pending' is first
            $requests = AssetRequest::with(['user', 'asset'])
                ->orderByRaw("FIELD(status, 'pending') DESC")
                ->orderBy('created_at', 'desc')
                ->paginate(10);  // Paginate the results with 10 per page
        } else {
            // Filter requests by the logged-in staff member
            $requests = AssetRequest::where('user_id', auth()->id())
                ->with(['asset'])
                ->orderByRaw("FIELD(status, 'pending') DESC")
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        return view('requests.index', compact('requests'));
    }


    public function approve($id)
    {
        $request = AssetRequest::findOrFail($id);

        // Create a transaction record
        Transaction::create([
            'user_id' => $request->user_id,
            'asset_id' => $request->asset_id,
            'transaction_type' => 'checkout',
            'quantity' => $request->quantity,
            'transaction_date' => now(),

        ]);

        // Update asset quantity
        $asset = Asset::findOrFail($request->asset_id);
        $asset->quantity -= $request->quantity;
        $asset->save();

        // Update request status
        $request->status = 'approved';
        $request->save();

        return redirect()->route('requests.index')->with('success', 'Request approved and asset checked out.');
    }


    public function reject($id)
    {
        $request = AssetRequest::findOrFail($id);
        $request->status = 'rejected';
        $request->save();

        return redirect()->route('requests.index')->with('success', 'Asset requests rejected.');
    }

    public function userHistory()
    {
        // Fetch the authenticated user's requests
        $requests = AssetRequest::where('user_id', auth()->id())->with('asset')->get();

        return view('asset_requests.index', compact('requests'));
    }

    public function requestAsset(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $asset = Asset::findOrFail($id);

        AssetRequest::create([
            'user_id' => auth()->id(),
            'asset_id' => $asset->id,
            'quantity' => $request->input('quantity'),
            'status' => 'pending',
        ]);

        return redirect()->route('asset.index')->with('success', 'Asset request submitted successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $asset = Asset::find($request->input('asset_id'));

        // Check if the asset exists
        if (!$asset) {
            return redirect()->back()->with('error', 'Asset not found.');
        }

        // Check if the asset is available and quantity requested does not exceed available quantity
        if ($asset->status !== 'available' || $request->input('quantity') > $asset->quantity) {
            return redirect()->back()->with('error', 'This asset is not available in the requested quantity.');
        }

        // Create the asset request
        AssetRequest::create([
            'user_id' => auth()->id(),
            'asset_id' => $asset->id,
            'quantity' => $request->input('quantity'),
            'status' => 'pending',
        ]);

        return redirect()->route('asset.index')->with('success', 'Asset request submitted successfully.');
    }


    public function destroy($id)
    {
        $request = AssetRequest::findOrFail($id);
        $request->delete();

        return redirect()->route('requests.index')->with('success', 'Request deleted successfully.');
    }

    public function create()
    {
        $assets = Asset::where('status', 'available')->get();
        return view('requests.create', compact('assets'));
    }

    public function edit($id)
    {
        $request = AssetRequest::findOrFail($id);
        $assets = Asset::where('status', 'available')->orderBy('name')->get();

        return view('requests.edit', compact('request', 'assets'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $assetRequest = AssetRequest::findOrFail($id);

        // Check if the new asset is available
        $asset = Asset::findOrFail($request->input('asset_id'));
        if ($asset->status !== 'available') {
            return redirect()->back()->with('error', 'This asset is not available for request.');
        }

        $assetRequest->update([
            'asset_id' => $request->input('asset_id'),
            'quantity' => $request->input('quantity'),
        ]);

        return redirect()->route('asset.index')->with('success', 'Asset request updated successfully.');
    }



}
