@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="space-y-6">
    <div class="app-card p-6 overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-gray-400 text-xs uppercase tracking-widest border-b border-gray-100">
                    <th class="pb-4">User</th>
                    <th class="pb-4">Balance</th>
                    <th class="pb-4">Status</th>
                    <th class="pb-4">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($users as $user)
                <tr>
                    <td class="py-4">
                        <div class="flex items-center">
                            <img src="https://ui-avatars.com/api/?name={{ $user->username }}&background=random" class="w-8 h-8 rounded-full mr-3" alt="">
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ $user->username }}</p>
                                <p class="text-[10px] text-gray-400">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 text-sm font-medium">${{ number_format($user->balance, 2) }}</td>
                    <td class="py-4">
                        <span class="px-2 py-1 rounded-full text-[10px] font-bold {{ $user->status === 'active' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                            {{ strtoupper($user->status) }}
                        </span>
                    </td>
                    <td class="py-4">
                        <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs font-bold {{ $user->status === 'active' ? 'text-red-500' : 'text-green-500' }}">
                                {{ $user->status === 'active' ? 'Suspend' : 'Activate' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
