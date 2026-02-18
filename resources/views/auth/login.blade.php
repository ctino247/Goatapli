@extends('layouts.guest')

@section('content')
<div class="h-full flex flex-col relative bg-black text-white">
    <!-- Top section with avatars like in image -->
    <div class="flex-1 flex flex-col items-center justify-center pb-64">
        <div class="relative mb-8">
            <img src="https://ui-avatars.com/api/?name=Dei&background=ffcc00&size=128" class="w-24 h-24 rounded-full border-4 border-gray-800" alt="avatar">
            <div class="absolute -top-4 -right-4">
                <img src="https://ui-avatars.com/api/?name=User&background=66ccff&size=64" class="w-12 h-12 rounded-full border-4 border-gray-800" alt="avatar">
            </div>
            <div class="absolute -bottom-4 -left-4">
                <img src="https://ui-avatars.com/api/?name=Dev&background=ff99cc&size=64" class="w-12 h-12 rounded-full border-4 border-gray-800" alt="avatar">
            </div>
        </div>
        <h1 class="text-3xl font-black text-center px-10 leading-tight">Let's get you signed in!</h1>
    </div>

    <!-- Login Card -->
    <div class="white-card text-gray-800">
        <p class="text-center text-gray-400 text-sm mb-6">You don't have an account yet? <a href="{{ route('register') }}" class="text-black font-bold">Sign Up</a></p>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <input type="text" name="login" value="{{ old('login') }}" class="w-full p-4 bg-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black" placeholder="Email or Phone">
                @error('login') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="relative">
                <input type="password" name="password" class="w-full p-4 bg-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black" placeholder="Password">
                <a href="#" class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">Forgot password?</a>
            </div>

            <button type="submit" class="w-full bg-black text-white py-4 rounded-2xl font-bold flex justify-between items-center px-8 mt-4 group">
                <span>Sign In</span>
                <i class="fas fa-arrow-right transition-transform group-hover:translate-x-1"></i>
            </button>
        </form>
    </div>
</div>
@endsection
