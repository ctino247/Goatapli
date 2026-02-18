<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use App\Models\UserContract;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_balance' => User::sum('balance'),
            'pending_withdrawals' => Transaction::where('type', 'withdrawal')->where('status', 'pending')->count(),
            'pending_deposits' => Transaction::where('type', 'deposit')->where('status', 'pending')->count(),
            'active_contracts' => UserContract::where('status', 'active')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function updateSettings(Request $request)
    {
        $data = $request->validate([
            'site_name' => 'nullable|string',
            'currency' => 'nullable|string',
            'commission_percentage' => 'nullable|numeric|min:0|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'smtp_host' => 'nullable|string',
            'smtp_port' => 'nullable|string',
            'smtp_encryption' => 'nullable|string',
            'smtp_username' => 'nullable|string',
            'smtp_password' => 'nullable|string',
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('settings', 'public');
            \App\Models\Setting::set('logo', $path);
        }

        foreach ($data as $key => $value) {
            if ($key !== 'logo' && $value && $value !== '********') {
                \App\Models\Setting::set($key, $value);
            }
        }

        return back()->with('success', 'Settings updated successfully.');
    }

    public function showBroadcast()
    {
        return view('admin.broadcast');
    }

    public function sendBroadcast(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'message' => 'required|string',
            'target' => 'required|in:all,active_contract',
        ]);

        $users = User::query();
        if ($request->target === 'active_contract') {
            $users->whereHas('activeContracts');
        }

        $users = $users->get();

        foreach ($users as $user) {
            \Illuminate\Support\Facades\Mail::to($user->email)->queue(new \App\Mail\BroadcastMail($request->subject, $request->message));
        }

        return back()->with('success', 'Broadcast email queued for ' . $users->count() . ' users.');
    }
}
