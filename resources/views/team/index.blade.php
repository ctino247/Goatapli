@extends('layouts.app')

@section('title', 'My Team')

@section('content')
<div class="space-y-6">
    <!-- Referral Summary -->
    <div class="app-card p-6 bg-gradient-to-br from-indigo-500 to-purple-600 text-white">
        <p class="text-indigo-100 text-xs">Direct Referrals</p>
        <h2 class="text-3xl font-black">{{ $referrals->count() }}</h2>
        <p class="text-[10px] mt-2 opacity-80">Earn commission from every contract purchase by your team members.</p>
    </div>

    <!-- Referral List -->
    <div>
        <h3 class="font-bold text-gray-800 mb-4">Team Members</h3>
        <div class="space-y-3">
            @forelse($referrals as $ref)
            <div class="app-card p-4 flex justify-between items-center">
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name={{ $ref->username }}&background=random" class="w-10 h-10 rounded-full mr-4" alt="avatar">
                    <div>
                        <p class="font-bold text-sm text-gray-800">{{ $ref->username }}</p>
                        <p class="text-[10px] text-gray-500">Joined: {{ $ref->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
                <div class="text-right">
                    @if($ref->activeContracts->count() > 0)
                        <span class="bg-green-100 text-green-700 text-[10px] px-2 py-0.5 rounded-full">Active Contract</span>
                    @else
                        <span class="bg-gray-100 text-gray-400 text-[10px] px-2 py-0.5 rounded-full">No Contract</span>
                    @endif
                </div>
            </div>
            @empty
            <div class="app-card p-10 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-gray-400 text-2xl"></i>
                </div>
                <p class="text-gray-500 text-sm">No referrals yet.</p>
                <p class="text-xs text-gray-400 mt-2">Share your link to build your team!</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
