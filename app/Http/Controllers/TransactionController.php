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
    $transactions = Transaction::with('user', 'asset')->get();
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
}
