<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>{{ \App\Models\Setting::get('site_name', config('app.name', 'Mobile Recruitment')) }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            padding-bottom: 80px; /* Space for bottom nav */
        }
        .app-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }
    </style>
</head>
<body class="antialiased">
    <div class="max-w-md mx-auto min-h-screen">
        <!-- Header -->
        <div class="p-6 flex justify-between items-center bg-white shadow-sm sticky top-0 z-10">
            <h1 class="text-xl font-bold text-gray-800">@yield('title')</h1>
            <div class="flex items-center space-x-4">
                <i class="fas fa-bell text-gray-500 text-lg"></i>
                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->username }}&background=random" class="w-8 h-8 rounded-full" alt="profile">
            </div>
        </div>

        <!-- Content -->
        <main class="p-4">
            @yield('content')
        </main>

        <!-- Bottom Navigation -->
        <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-6 py-3 flex justify-between items-center z-50 max-w-md mx-auto">
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-400' }}">
                <i class="fas fa-home text-xl"></i>
                <span class="text-[10px] mt-1 font-medium">Home</span>
            </a>
            <a href="{{ route('contracts.index') }}" class="flex flex-col items-center {{ request()->routeIs('contracts.*') ? 'text-blue-600' : 'text-gray-400' }}">
                <i class="fas fa-file-contract text-xl"></i>
                <span class="text-[10px] mt-1 font-medium">Contracts</span>
            </a>
            <a href="{{ route('team.index') }}" class="flex flex-col items-center {{ request()->routeIs('team.*') ? 'text-blue-600' : 'text-gray-400' }}">
                <i class="fas fa-users text-xl"></i>
                <span class="text-[10px] mt-1 font-medium">Team</span>
            </a>
            <a href="{{ route('wallet.index') }}" class="flex flex-col items-center {{ request()->routeIs('wallet.*') ? 'text-blue-600' : 'text-gray-400' }}">
                <i class="fas fa-wallet text-xl"></i>
                <span class="text-[10px] mt-1 font-medium">Wallet</span>
            </a>
            <a href="{{ route('profile.index') }}" class="flex flex-col items-center {{ request()->routeIs('profile.*') ? 'text-blue-600' : 'text-gray-400' }}">
                <i class="fas fa-user text-xl"></i>
                <span class="text-[10px] mt-1 font-medium">Profile</span>
            </a>
        </nav>
    </div>
</body>
</html>
