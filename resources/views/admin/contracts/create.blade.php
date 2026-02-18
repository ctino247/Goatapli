@extends('layouts.app')

@section('title', 'Create Contract')

@section('content')
<div class="app-card p-6">
    <form action="{{ route('admin.contracts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Contract Name</label>
                <input type="text" name="name" class="w-full p-4 bg-gray-100 rounded-xl focus:outline-none" required>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Price ($)</label>
                <input type="number" name="price" step="0.01" class="w-full p-4 bg-gray-100 rounded-xl focus:outline-none" required>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Benefits (Semicolon separated)</label>
                <textarea name="benefits" class="w-full p-4 bg-gray-100 rounded-xl focus:outline-none" rows="3" required></textarea>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Duration (Days)</label>
                <input type="number" name="duration_days" class="w-full p-4 bg-gray-100 rounded-xl focus:outline-none" required>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Contract Document (Optional)</label>
                <input type="file" name="contract_file" class="w-full p-2 bg-gray-100 rounded-xl text-sm">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold mt-4">Create Contract</button>
        </div>
    </form>
</div>
@endsection
