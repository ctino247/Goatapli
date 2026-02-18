@extends('layouts.app')

@section('title', 'Contracts')

@section('content')
<div class="space-y-6">
    <p class="text-gray-500 text-sm">Choose a contract to start earning commissions and daily bonuses.</p>

    @foreach($contracts as $contract)
    <div class="app-card overflow-hidden">
        <div class="bg-blue-600 p-4 text-white flex justify-between items-center">
            <h3 class="font-bold text-lg">{{ $contract->name }}</h3>
            <span class="bg-white/20 px-3 py-1 rounded-lg text-sm font-bold">${{ number_format($contract->price, 2) }}</span>
        </div>
        <div class="p-6">
            <ul class="space-y-3 mb-6">
                @foreach(explode(';', $contract->benefits) as $benefit)
                <li class="flex items-start text-sm text-gray-600">
                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                    {{ trim($benefit) }}
                </li>
                @endforeach
                <li class="flex items-start text-sm text-gray-600">
                    <i class="fas fa-clock text-blue-500 mt-1 mr-3"></i>
                    Duration: {{ $contract->duration_days }} Days
                </li>
            </ul>

            <a href="{{ route('contracts.show', $contract->id) }}" class="block w-full bg-blue-600 text-white py-4 rounded-2xl font-bold text-center hover:bg-blue-700 transition">
                View & Purchase
            </a>
        </div>
    </div>
    @endforeach
</div>
@endsection
