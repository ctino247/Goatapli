<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $referrals = $user->referrals()->with('activeContracts')->get();
        return view('team.index', compact('referrals'));
    }
}
