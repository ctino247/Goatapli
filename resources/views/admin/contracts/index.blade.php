@extends('layouts.app')

@section('title', 'Manage Contracts')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h3 class="font-bold text-gray-800">Available Contracts</h3>
        <a href="{{ route('admin.contracts.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-xs font-bold">Add New</a>
    </div>

    <div class="space-y-4">
        @foreach($contracts as $contract)
        <div class="app-card p-4 flex justify-between items-center">
            <div>
                <p class="font-bold text-gray-800">{{ $contract->name }}</p>
                <p class="text-xs text-gray-500">${{ number_format($contract->price, 2) }} - {{ $contract->duration_days }} Days</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.contracts.edit', $contract->id) }}" class="text-blue-600 p-2">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
