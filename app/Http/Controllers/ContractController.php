<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\UserContract;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::where('is_active', true)->get();
        return view('contracts.index', compact('contracts'));
    }

    public function show(Contract $contract)
    {
        return view('contracts.show', compact('contract'));
    }

    public function purchase(Request $request, Contract $contract)
    {
        $user = Auth::user();

        if ($user->balance < $contract->price) {
            return back()->withErrors(['balance' => 'Insufficient balance. Please deposit funds first.']);
        }

        // Deduct balance
        $user->balance -= $contract->price;
        $user->save();

        // Create user contract
        UserContract::create([
            'user_id' => $user->id,
            'contract_id' => $contract->id,
            'status' => 'active',
            'expires_at' => Carbon::now()->addDays($contract->duration_days),
        ]);

        // Create transaction record
        Transaction::create([
            'user_id' => $user->id,
            'amount' => -$contract->price,
            'type' => 'purchase',
            'status' => 'completed',
            'description' => 'Purchased contract: ' . $contract->name,
        ]);

        // Referral commission logic
        if ($user->referred_by) {
            $referrer = $user->referrer;
            // Get commission percentage from settings or default to 10%
            $commissionPercent = \App\Models\Setting::get('commission_percentage', 10);
            $commissionAmount = ($contract->price * $commissionPercent) / 100;

            $referrer->balance += $commissionAmount;
            $referrer->save();

            Transaction::create([
                'user_id' => $referrer->id,
                'amount' => $commissionAmount,
                'type' => 'commission',
                'status' => 'completed',
                'description' => 'Referral commission from ' . $user->username,
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Contract purchased successfully!');
    }
}
