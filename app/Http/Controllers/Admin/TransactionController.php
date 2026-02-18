<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user')->latest()->paginate(20);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function approve(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaction is not pending.');
        }

        if ($transaction->type === 'deposit') {
            $user = $transaction->user;
            $user->balance += $transaction->amount;
            $user->save();
        }

        $transaction->status = 'approved';
        $transaction->save();

        return back()->with('success', 'Transaction approved.');
    }

    public function reject(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaction is not pending.');
        }

        if ($transaction->type === 'withdrawal') {
            // Refund the balance
            $user = $transaction->user;
            $user->balance += abs($transaction->amount);
            $user->save();
        }

        $transaction->status = 'rejected';
        $transaction->save();

        return back()->with('success', 'Transaction rejected.');
    }
}
