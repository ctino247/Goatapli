@extends('layouts.guest')

@section('content')
<div class="h-full flex flex-col relative" x-data="{
    step: 'onboarding',
    regStep: 1,
    init() {
        if (localStorage.getItem('onboarding_completed')) {
            this.step = 'register';
        }
    },
    completeOnboarding() {
        localStorage.setItem('onboarding_completed', true);
        this.step = 'register';
    }
}">
    <!-- Onboarding Screens -->
    <div x-show="step === 'onboarding'" class="h-full flex flex-col bg-black text-white overflow-hidden">
        <div class="swiper mySwiper flex-1 w-full">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide p-8 flex flex-col items-center justify-center text-center">
                    <div class="relative mb-12">
                         <img src="https://ui-avatars.com/api/?name=Recruit&background=66ccff&size=128" class="w-32 h-32 rounded-full border-4 border-gray-800" alt="avatar">
                    </div>
                    <h2 class="text-3xl font-black mb-4">Welcome to Recruitment</h2>
                    <p class="text-gray-400 px-6">The most advanced referral and recruitment platform for modern professionals.</p>
                </div>
                <!-- Slide 2 -->
                <div class="swiper-slide p-8 flex flex-col items-center justify-center text-center">
                    <div class="relative mb-12">
                         <img src="https://ui-avatars.com/api/?name=Earn&background=ffcc00&size=128" class="w-32 h-32 rounded-full border-4 border-gray-800" alt="avatar">
                    </div>
                    <h2 class="text-3xl font-black mb-4">Earn from Referrals</h2>
                    <p class="text-gray-400 px-6">Invite your friends and earn commissions on every contract they purchase.</p>
                </div>
                <!-- Slide 3 -->
                <div class="swiper-slide p-8 flex flex-col items-center justify-center text-center">
                    <div class="relative mb-12">
                         <img src="https://ui-avatars.com/api/?name=Start&background=ff99cc&size=128" class="w-32 h-32 rounded-full border-4 border-gray-800" alt="avatar">
                    </div>
                    <h2 class="text-3xl font-black mb-4">Get Started Now</h2>
                    <p class="text-gray-400 px-6">Create your account in just a few steps and start your journey.</p>
                </div>
            </div>
            <div class="swiper-pagination !bottom-8"></div>
        </div>

        <div class="white-card text-gray-800">
             <button @click="completeOnboarding()" class="w-full bg-black text-white py-4 rounded-2xl font-bold flex justify-between items-center px-8 group">
                <span>Create Account</span>
                <i class="fas fa-arrow-right transition-transform group-hover:translate-x-1"></i>
            </button>
            <p class="text-center text-gray-400 text-sm mt-6">Already have an account? <a href="{{ route('login') }}" class="text-black font-bold">Login</a></p>
        </div>
    </div>

    <!-- Registration Flow -->
    <div x-show="step === 'register'" x-cloak class="h-full flex flex-col bg-black text-white">
        <div class="flex-1 flex flex-col items-center justify-center pb-64">
             <h1 class="text-3xl font-black text-center px-10 leading-tight">Create your account</h1>
             <p class="text-gray-400 mt-2">Join our elite team today</p>
        </div>

        <div class="white-card text-gray-800 min-h-[450px]">
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <input type="hidden" name="referral_code" value="{{ $ref }}">

                <!-- Step 1: Phone -->
                <div x-show="regStep === 1" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0">
                    <label class="block text-gray-400 text-xs font-bold mb-2 uppercase tracking-widest">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full p-4 bg-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black mb-6" placeholder="+123 456 7890">
                    @error('phone') <p class="text-red-500 text-xs mt-1 mb-4">{{ $message }}</p> @enderror
                    <button type="button" @click="regStep = 2" class="w-full bg-black text-white py-4 rounded-2xl font-bold flex justify-between items-center px-8">
                        <span>Continue</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>

                <!-- Step 2: Email -->
                <div x-show="regStep === 2" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0">
                    <label class="block text-gray-400 text-xs font-bold mb-2 uppercase tracking-widest">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full p-4 bg-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black mb-6" placeholder="hello@world.com">
                    @error('email') <p class="text-red-500 text-xs mt-1 mb-4">{{ $message }}</p> @enderror
                    <div class="flex space-x-4">
                        <button type="button" @click="regStep = 1" class="bg-gray-100 text-gray-400 p-4 rounded-2xl font-bold"><i class="fas fa-arrow-left"></i></button>
                        <button type="button" @click="regStep = 3" class="flex-1 bg-black text-white py-4 rounded-2xl font-bold flex justify-between items-center px-8">
                            <span>Next</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Username -->
                <div x-show="regStep === 3" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0">
                    <label class="block text-gray-400 text-xs font-bold mb-2 uppercase tracking-widest">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" class="w-full p-4 bg-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black mb-6" placeholder="johndoe">
                    @error('username') <p class="text-red-500 text-xs mt-1 mb-4">{{ $message }}</p> @enderror
                    <div class="flex space-x-4">
                        <button type="button" @click="regStep = 2" class="bg-gray-100 text-gray-400 p-4 rounded-2xl font-bold"><i class="fas fa-arrow-left"></i></button>
                        <button type="button" @click="regStep = 4" class="flex-1 bg-black text-white py-4 rounded-2xl font-bold flex justify-between items-center px-8">
                            <span>Next</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 4: Password -->
                <div x-show="regStep === 4" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0">
                    <label class="block text-gray-400 text-xs font-bold mb-2 uppercase tracking-widest">Secure Password</label>
                    <input type="password" name="password" class="w-full p-4 bg-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black mb-4" placeholder="********">
                    <input type="password" name="password_confirmation" class="w-full p-4 bg-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black mb-6" placeholder="Confirm Password">
                    @error('password') <p class="text-red-500 text-xs mt-1 mb-4">{{ $message }}</p> @enderror
                    <div class="flex space-x-4">
                        <button type="button" @click="regStep = 3" class="bg-gray-100 text-gray-400 p-4 rounded-2xl font-bold"><i class="fas fa-arrow-left"></i></button>
                        <button type="button" @click="regStep = 5" class="flex-1 bg-black text-white py-4 rounded-2xl font-bold flex justify-between items-center px-8">
                            <span>Review</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 5: Confirm -->
                <div x-show="regStep === 5" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0">
                    <div class="bg-gray-50 p-6 rounded-3xl mb-8 space-y-4">
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-gray-400 text-xs font-bold uppercase">Phone</span>
                            <span class="font-bold text-sm" x-text="$root.querySelector('input[name=phone]').value"></span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-gray-400 text-xs font-bold uppercase">Email</span>
                            <span class="font-bold text-sm" x-text="$root.querySelector('input[name=email]').value"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400 text-xs font-bold uppercase">User</span>
                            <span class="font-bold text-sm" x-text="$root.querySelector('input[name=username]').value"></span>
                        </div>
                    </div>
                    <div class="flex space-x-4">
                        <button type="button" @click="regStep = 4" class="bg-gray-100 text-gray-400 p-4 rounded-2xl font-bold"><i class="fas fa-arrow-left"></i></button>
                        <button type="submit" class="flex-1 bg-green-500 text-white py-4 rounded-2xl font-bold flex justify-between items-center px-8">
                            <span>Confirm & Join</span>
                            <i class="fas fa-check"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper(".mySwiper", {
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    });
</script>
<style>
    [x-cloak] { display: none !important; }
    .swiper-pagination-bullet-active {
        background: #2563eb !important;
    }
</style>
@endsection
