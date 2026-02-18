@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-2 gap-4">
        <div class="app-card p-4">
            <p class="text-gray-500 text-xs uppercase">Total Users</p>
            <p class="text-xl font-bold">{{ $stats['total_users'] }}</p>
        </div>
        <div class="app-card p-4">
            <p class="text-gray-500 text-xs uppercase">Total Balance</p>
            <p class="text-xl font-bold">${{ number_format($stats['total_balance'], 2) }}</p>
        </div>
        <div class="app-card p-4">
            <p class="text-gray-500 text-xs uppercase text-orange-600">Pending Withdrawals</p>
            <p class="text-xl font-bold">{{ $stats['pending_withdrawals'] }}</p>
        </div>
        <div class="app-card p-4">
            <p class="text-gray-500 text-xs uppercase text-green-600">Pending Deposits</p>
            <p class="text-xl font-bold">{{ $stats['pending_deposits'] }}</p>
        </div>
    </div>

    <div class="app-card overflow-hidden">
        <div class="p-4 border-b border-gray-100 font-bold">Admin Actions</div>
        <div class="divide-y divide-gray-100">
            <a href="{{ route('admin.transactions.index') }}" class="flex items-center justify-between p-4 hover:bg-gray-50">
                <span>Manage Transactions</span>
                <i class="fas fa-chevron-right text-gray-300"></i>
            </a>
            <a href="{{ route('admin.users.index') }}" class="flex items-center justify-between p-4 hover:bg-gray-50">
                <span>Manage Users</span>
                <i class="fas fa-chevron-right text-gray-300"></i>
            </a>
            <a href="{{ route('admin.contracts.index') }}" class="flex items-center justify-between p-4 hover:bg-gray-50">
                <span>Manage Contracts</span>
                <i class="fas fa-chevron-right text-gray-300"></i>
            </a>
            <a href="{{ route('admin.broadcast.show') }}" class="flex items-center justify-between p-4 hover:bg-gray-50">
                <span>Send Broadcast Email</span>
                <i class="fas fa-chevron-right text-gray-300"></i>
            </a>
        </div>
    </div>
</div>
@endsection
