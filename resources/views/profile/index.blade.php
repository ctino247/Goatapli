@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="space-y-6">
    <div class="app-card p-6 flex flex-col items-center">
        <img src="https://ui-avatars.com/api/?name={{ $user->username }}&background=random&size=128" class="w-24 h-24 rounded-full mb-4 shadow-md" alt="profile">
        <h2 class="text-xl font-bold">{{ $user->username }}</h2>
        <p class="text-gray-500 text-sm">{{ $user->email }}</p>
        <div class="mt-4 flex space-x-2">
            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">{{ strtoupper($user->status) }}</span>
            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">VERIFIED</span>
        </div>
    </div>

    <div class="app-card overflow-hidden">
        <div class="divide-y divide-gray-100">
            <a href="#" class="flex items-center justify-between p-4 hover:bg-gray-50">
                <div class="flex items-center">
                    <i class="fas fa-user-edit text-gray-400 mr-4"></i>
                    <span class="text-sm font-medium">Edit Profile</span>
                </div>
                <i class="fas fa-chevron-right text-gray-300"></i>
            </a>
            <a href="#" class="flex items-center justify-between p-4 hover:bg-gray-50">
                <div class="flex items-center">
                    <i class="fas fa-shield-alt text-gray-400 mr-4"></i>
                    <span class="text-sm font-medium">Security</span>
                </div>
                <i class="fas fa-chevron-right text-gray-300"></i>
            </a>
            <a href="#" class="flex items-center justify-between p-4 hover:bg-gray-50">
                <div class="flex items-center">
                    <i class="fas fa-question-circle text-gray-400 mr-4"></i>
                    <span class="text-sm font-medium">Support</span>
                </div>
                <i class="fas fa-chevron-right text-gray-300"></i>
            </a>
        </div>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="w-full bg-red-50 text-red-600 py-4 rounded-2xl font-bold hover:bg-red-100 transition">
            Logout
        </button>
    </form>
</div>
@endsection
