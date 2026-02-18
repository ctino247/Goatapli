@extends('layouts.app')

@section('title', 'Send Broadcast Email')

@section('content')
<div class="space-y-6">
    <div class="app-card p-6">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-xl text-sm font-bold">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.broadcast.send') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-400 text-xs font-bold mb-2 uppercase tracking-widest">Target Audience</label>
                <select name="target" class="w-full p-4 bg-gray-50 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black">
                    <option value="all">All Users</option>
                    <option value="active_contract">Active Contract Holders Only</option>
                </select>
                @error('target') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-400 text-xs font-bold mb-2 uppercase tracking-widest">Email Subject</label>
                <input type="text" name="subject" class="w-full p-4 bg-gray-50 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black" placeholder="Important Update">
                @error('subject') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-400 text-xs font-bold mb-2 uppercase tracking-widest">Message Content</label>
                <textarea name="message" rows="6" class="w-full p-4 bg-gray-50 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black" placeholder="Enter your message here..."></textarea>
                @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full bg-black text-white py-4 rounded-2xl font-bold flex justify-between items-center px-8 group">
                <span>Send Broadcast</span>
                <i class="fas fa-paper-plane transition-transform group-hover:translate-x-1"></i>
            </button>
        </form>
    </div>
</div>
@endsection
