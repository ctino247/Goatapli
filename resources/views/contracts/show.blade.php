@extends('layouts.app')

@section('title', 'Contract Details')

@section('content')
<div class="space-y-6" x-data="{ read: false }">
    <div class="app-card overflow-hidden">
        <div class="bg-blue-600 p-4 text-white">
            <h3 class="font-bold text-lg">{{ $contract->name }}</h3>
        </div>
        <div class="p-6">
            <p class="text-gray-600 mb-4">{{ $contract->benefits }}</p>

            @if($contract->file_path)
            <div class="mb-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
                <p class="text-sm font-bold text-gray-700 mb-2">Contract Agreement:</p>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-500">Document attached</span>
                    <a href="{{ asset('storage/' . $contract->file_path) }}" target="_blank" class="text-blue-600 text-sm font-bold underline">
                        <i class="fas fa-file-pdf mr-1"></i> View/Download
                    </a>
                </div>
            </div>
            @endif

            <div class="flex items-center mb-6">
                <input type="checkbox" id="read_agreement" x-model="read" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="read_agreement" class="ml-2 text-sm text-gray-600">I have read and agree to the contract terms.</label>
            </div>

            <form action="{{ route('contracts.purchase', $contract->id) }}" method="POST">
                @csrf
                <button type="submit" :disabled="!read" :class="read ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-300 cursor-not-allowed'" class="w-full text-white py-4 rounded-2xl font-bold transition">
                    Purchase for ${{ number_format($contract->price, 2) }}
                </button>
            </form>
        </div>
    </div>

    <a href="{{ route('contracts.index') }}" class="block text-center text-gray-500 text-sm font-bold">
        <i class="fas fa-arrow-left mr-1"></i> Back to Contracts
    </a>
</div>
@endsection
