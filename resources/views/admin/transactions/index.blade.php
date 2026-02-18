@extends('layouts.app')

@section('title', 'Transactions')

@section('content')
<div class="space-y-6">
    <div class="app-card p-6 overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-gray-400 text-xs uppercase tracking-widest border-b border-gray-100">
                    <th class="pb-4">User</th>
                    <th class="pb-4">Type</th>
                    <th class="pb-4">Amount</th>
                    <th class="pb-4">Status</th>
                    <th class="pb-4">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($transactions as $tx)
                <tr>
                    <td class="py-4">
                        <p class="text-sm font-bold text-gray-800">{{ $tx->user->username }}</p>
                    </td>
                    <td class="py-4">
                        <span class="text-xs font-medium text-gray-500 uppercase">{{ $tx->type }}</span>
                    </td>
                    <td class="py-4 text-sm font-bold {{ $tx->amount > 0 ? 'text-green-600' : 'text-red-600' }}">
                        ${{ number_format($tx->amount, 2) }}
                    </td>
                    <td class="py-4">
                        <span class="px-2 py-1 rounded-full text-[10px] font-bold
                            {{ $tx->status === 'approved' ? 'bg-green-100 text-green-600' : '' }}
                            {{ $tx->status === 'pending' ? 'bg-yellow-100 text-yellow-600' : '' }}
                            {{ $tx->status === 'rejected' ? 'bg-red-100 text-red-600' : '' }}">
                            {{ strtoupper($tx->status) }}
                        </span>
                    </td>
                    <td class="py-4">
                        @if($tx->status === 'pending')
                        <div class="flex space-x-2">
                            <form action="{{ route('admin.transactions.approve', $tx->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xs font-bold text-green-600">Approve</button>
                            </form>
                            <form action="{{ route('admin.transactions.reject', $tx->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xs font-bold text-red-600">Reject</button>
                            </form>
                        </div>
                        @else
                        <span class="text-xs text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-6">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
