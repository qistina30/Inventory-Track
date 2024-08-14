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
        // Fetch all requests with associated users and assets
        $requests = AssetRequest::with(['user', 'asset'])->get();

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
            'remark' => 'Approved request ID: ' . $request->id,
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

        $asset = Asset::findOrFail($request->input('asset_id'));

        // Check if the asset is available before processing the request
        if ($asset->status !== 'available') {
            return redirect()->back()->with('error', 'This asset is not available for request.');
        }

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


}
