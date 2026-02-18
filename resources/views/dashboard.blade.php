@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Wallet Card -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 rounded-[30px] text-white shadow-lg">
        <p class="text-blue-100 text-sm opacity-80">Total Balance</p>
        <h2 class="text-3xl font-bold mt-1">{{ \App\Models\Setting::get('currency', '$') }}{{ number_format($user->balance, 2) }}</h2>
        <div class="flex mt-6 space-x-4">
            <a href="{{ route('wallet.index') }}" class="flex-1 bg-white/20 hover:bg-white/30 py-3 rounded-2xl backdrop-blur-md transition text-center">
                <i class="fas fa-plus-circle mr-2"></i> Deposit
            </a>
            <a href="{{ route('wallet.index') }}" class="flex-1 bg-white/20 hover:bg-white/30 py-3 rounded-2xl backdrop-blur-md transition text-center">
                <i class="fas fa-arrow-alt-circle-up mr-2"></i> Withdraw
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 gap-4">
        <div class="app-card p-4">
            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mb-3">
                <i class="fas fa-coins text-yellow-600"></i>
            </div>
            <p class="text-gray-500 text-xs">Coins Wallet</p>
            <p class="text-lg font-bold">{{ number_format($user->coins_balance, 2) }}</p>
        </div>
        <div class="app-card p-4">
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mb-3">
                <i class="fas fa-users text-green-600"></i>
            </div>
            <p class="text-gray-500 text-xs">Team Earnings</p>
            <p class="text-lg font-bold">{{ \App\Models\Setting::get('currency', '$') }}0.00</p>
        </div>
    </div>

    <!-- Active Contract -->
    <div class="app-card p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-gray-800">Active Contract</h3>
            <a href="{{ route('contracts.index') }}" class="text-blue-600 text-sm font-semibold">View All</a>
        </div>
        @php $activeContract = $user->activeContracts()->first(); @endphp
        @if($activeContract)
            <div class="flex items-center p-4 bg-gray-50 rounded-2xl">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-file-contract text-blue-600"></i>
                </div>
                <div>
                    <p class="font-bold text-gray-800">{{ $activeContract->contract->name }}</p>
                    <p class="text-xs text-gray-500">Expires: {{ $activeContract->expires_at->format('M d, Y') }}</p>
                </div>
            </div>
        @else
            <div class="text-center py-6">
                <p class="text-gray-500 text-sm mb-4">You don't have an active contract</p>
                <a href="{{ route('contracts.index') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-xl text-sm font-bold">Purchase Now</a>
            </div>
        @endif
    </div>

    <!-- Referral Link -->
    <div class="app-card p-6">
        <h3 class="font-bold text-gray-800 mb-4">Your Referral Link</h3>
        <div class="flex items-center bg-gray-50 p-3 rounded-xl border border-dashed border-gray-300">
            <input type="text" readonly value="{{ url('/register?ref=' . $user->referral_code) }}" class="bg-transparent text-xs text-gray-600 flex-1 outline-none">
            <button onclick="navigator.clipboard.writeText('{{ url('/register?ref=' . $user->referral_code) }}')" class="ml-2 text-blue-600">
                <i class="far fa-copy"></i>
            </button>
        </div>
    </div>
</div>
@endsection
