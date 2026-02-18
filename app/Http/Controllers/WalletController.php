<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $transactions = Transaction::where('user_id', $user->id)->latest()->get();
        return view('wallet.index', compact('user', 'transactions'));
    }

    public function deposit(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);

        Transaction::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'type' => 'deposit',
            'status' => 'pending',
            'description' => 'Deposit request',
        ]);

        return back()->with('success', 'Deposit request submitted. Please wait for admin approval.');
    }

    public function withdraw(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:10']);
        $user = Auth::user();

        if ($user->balance < $request->amount) {
             return back()->withErrors(['amount' => 'Insufficient balance.']);
        }

        Transaction::create([
            'user_id' => $user->id,
            'amount' => -$request->amount,
            'type' => 'withdrawal',
            'status' => 'pending',
            'description' => 'Withdrawal request',
        ]);

        // We don't deduct balance until it is approved, OR we can deduct now and refund if rejected.
        // Usually, it's safer to deduct now.
        $user->balance -= $request->amount;
        $user->save();

        return back()->with('success', 'Withdrawal request submitted.');
    }
}
