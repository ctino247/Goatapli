@extends('layouts.app')

@section('title', 'My Wallet')

@section('content')
<div class="space-y-6">
    <!-- Balance Card -->
    <div class="app-card p-6 text-center">
        <p class="text-gray-500 text-sm">Main Balance</p>
        <h2 class="text-4xl font-black text-gray-800 mt-2">${{ number_format($user->balance, 2) }}</h2>
    </div>

    <!-- Actions -->
    <div class="grid grid-cols-2 gap-4" x-data="{ showDeposit: false, showWithdraw: false }">
        <button @click="showDeposit = true" class="app-card p-4 flex flex-col items-center">
            <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center mb-2">
                <i class="fas fa-plus text-green-600"></i>
            </div>
            <span class="text-sm font-bold text-gray-700">Deposit</span>
        </button>
        <button @click="showWithdraw = true" class="app-card p-4 flex flex-col items-center">
            <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center mb-2">
                <i class="fas fa-arrow-up text-orange-600"></i>
            </div>
            <span class="text-sm font-bold text-gray-700">Withdraw</span>
        </button>

        <!-- Deposit Modal (Simplified for mobile style) -->
        <div x-show="showDeposit" class="fixed inset-0 z-[60] flex items-end justify-center px-4 pb-4" x-cloak>
            <div @click="showDeposit = false" class="fixed inset-0 bg-black/50"></div>
            <div class="bg-white w-full max-w-md rounded-[30px] p-8 z-10 animate-slide-up">
                <h3 class="text-xl font-bold mb-4">Request Deposit</h3>
                <form action="{{ route('wallet.deposit') }}" method="POST">
                    @csrf
                    <input type="number" name="amount" step="0.01" class="w-full p-4 bg-gray-100 rounded-xl mb-4" placeholder="Enter Amount ($)">
                    <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold">Submit Request</button>
                </form>
            </div>
        </div>

        <!-- Withdraw Modal -->
        <div x-show="showWithdraw" class="fixed inset-0 z-[60] flex items-end justify-center px-4 pb-4" x-cloak>
            <div @click="showWithdraw = false" class="fixed inset-0 bg-black/50"></div>
            <div class="bg-white w-full max-w-md rounded-[30px] p-8 z-10 animate-slide-up">
                <h3 class="text-xl font-bold mb-4">Request Withdrawal</h3>
                <form action="{{ route('wallet.withdraw') }}" method="POST">
                    @csrf
                    <input type="number" name="amount" step="0.01" class="w-full p-4 bg-gray-100 rounded-xl mb-4" placeholder="Enter Amount ($)">
                    <button type="submit" class="w-full bg-orange-600 text-white py-4 rounded-xl font-bold">Submit Withdrawal</button>
                </form>
            </div>
        </div>
    </div>

    <!-- History -->
    <div>
        <h3 class="font-bold text-gray-800 mb-4">Transaction History</h3>
        <div class="space-y-3">
            @forelse($transactions as $tx)
            <div class="app-card p-4 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="w-10 h-10 {{ $tx->amount > 0 ? 'bg-green-100' : 'bg-red-100' }} rounded-full flex items-center justify-center mr-4">
                        <i class="fas {{ $tx->amount > 0 ? 'fa-arrow-down text-green-600' : 'fa-arrow-up text-red-600' }}"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm text-gray-800">{{ ucfirst($tx->type) }}</p>
                        <p class="text-[10px] text-gray-500">{{ $tx->created_at->format('M d, H:i') }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-bold {{ $tx->amount > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $tx->amount > 0 ? '+' : '' }}${{ number_format(abs($tx->amount), 2) }}
                    </p>
                    <span class="text-[10px] px-2 py-0.5 rounded-full {{ $tx->status === 'approved' || $tx->status === 'completed' ? 'bg-green-100 text-green-700' : ($tx->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                        {{ ucfirst($tx->status) }}
                    </span>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-500 py-10">No transactions yet.</p>
            @endforelse
        </div>
    </div>
</div>

<style>
    .animate-slide-up {
        animation: slide-up 0.3s ease-out;
    }
    @keyframes slide-up {
        from { transform: translateY(100%); }
        to { transform: translateY(0); }
    }
    [x-cloak] { display: none !important; }
</style>
@endsection
