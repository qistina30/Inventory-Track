<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $transactions = Transaction::with('user', 'asset')->paginate(10);;
    return view('transactions.index', compact('transactions'));
}

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
//            'quantity' => 'required|integer',
            'remark' => 'nullable|string',
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->update([
//            'quantity' => $request->quantity,
            'remark' => $request->remark,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }

    // TransactionController.php

    public function returnForm($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('transactions.return', compact('transaction'));
    }

    public function processReturn(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        // Validate input
        $request->validate([
            'remark' => 'nullable|string|max:255',
        ]);

        // Update transaction type to "return" and save remark
        $transaction->update([
            'transaction_type' => 'return',
            'remark' => $request->remark,
            'transaction_date' => now(),
        ]);

        // Adjust asset quantity based on the remark
        $asset = $transaction->asset;

        // If remark is not "damaged", increase the asset quantity
        if ($request->remark !== 'damaged') {
            $asset->quantity += $transaction->quantity;
        }

        $asset->save();

        return redirect()->route('transactions.index')->with('success', 'Asset returned successfully!');
    }


}
