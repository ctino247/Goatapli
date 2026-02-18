@extends('layouts.app')

@section('title', 'Edit Contract')

@section('content')
<div class="app-card p-6">
    <form action="{{ route('admin.contracts.update', $contract->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="space-y-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Contract Name</label>
                <input type="text" name="name" value="{{ $contract->name }}" class="w-full p-4 bg-gray-100 rounded-xl focus:outline-none" required>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Price ($)</label>
                <input type="number" name="price" value="{{ $contract->price }}" step="0.01" class="w-full p-4 bg-gray-100 rounded-xl focus:outline-none" required>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Benefits (Semicolon separated)</label>
                <textarea name="benefits" class="w-full p-4 bg-gray-100 rounded-xl focus:outline-none" rows="3" required>{{ $contract->benefits }}</textarea>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Duration (Days)</label>
                <input type="number" name="duration_days" value="{{ $contract->duration_days }}" class="w-full p-4 bg-gray-100 rounded-xl focus:outline-none" required>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Contract Document (Optional)</label>
                @if($contract->file_path)
                    <p class="text-xs text-gray-500 mb-2">Current file: {{ basename($contract->file_path) }}</p>
                @endif
                <input type="file" name="contract_file" class="w-full p-2 bg-gray-100 rounded-xl text-sm">
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" {{ $contract->is_active ? 'checked' : '' }} class="w-4 h-4 text-blue-600">
                <label for="is_active" class="ml-2 text-sm text-gray-700">Is Active</label>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold mt-4">Update Contract</button>
        </div>
    </form>
</div>
@endsection
