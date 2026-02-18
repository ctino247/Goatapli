@extends('layouts.guest')

@section('content')
<div class="h-full flex flex-col relative bg-black text-white" x-data="{ timer: 60, canResend: false }">
    <div class="flex-1 flex flex-col items-center justify-center pb-64">
        <div class="w-24 h-24 bg-gray-800 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-envelope-open-text text-4xl text-blue-400"></i>
        </div>
        <h1 class="text-3xl font-black text-center px-10 leading-tight">Check your email</h1>
        <p class="text-gray-400 mt-2">We sent a code to <span class="text-white">{{ $email }}</span></p>
    </div>

    <div class="white-card text-gray-800">
        <form action="{{ route('verify.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="mb-8">
                <label class="block text-gray-400 text-xs font-bold mb-4 uppercase tracking-widest text-center">Enter 6-digit Code</label>
                <input type="text" name="otp" maxlength="6" class="w-full text-center text-3xl tracking-[0.5rem] font-black p-5 bg-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black" placeholder="000000">
                @error('otp') <p class="text-red-500 text-xs mt-2 text-center">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full bg-black text-white py-4 rounded-2xl font-bold flex justify-between items-center px-8 group">
                <span>Verify Now</span>
                <i class="fas fa-check-circle transition-transform group-hover:scale-110"></i>
            </button>
        </form>

        <div class="mt-8 text-center" x-init="setInterval(() => { if(timer > 0) timer-- else canResend = true }, 1000)">
            <p class="text-gray-400 text-sm" x-show="!canResend">
                Resend code in <span class="font-bold text-black" x-text="timer"></span>s
            </p>

            <form action="{{ route('otp.resend') }}" method="POST" x-show="canResend" x-cloak>
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <button type="submit" class="text-black font-black underline">Resend OTP Code</button>
            </form>
        </div>

        @if(session('success'))
            <div class="mt-4 p-4 bg-green-50 text-green-600 rounded-2xl text-xs font-bold text-center">
                {{ session('success') }}
            </div>
        @endif
    </div>
</div>
<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
