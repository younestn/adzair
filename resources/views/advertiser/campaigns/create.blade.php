@extends('layouts.app')

@section('title', 'Create Campaign')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6">Create New Campaign</h2>
    
    <form method="POST" action="{{ route('advertiser.campaigns.store') }}">
        @csrf
        
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold mb-2">Campaign Name</label>
            <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>
            @error('name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>
        
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500"></textarea>
            @error('description')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label for="budget" class="block text-gray-700 font-semibold mb-2">Budget ($)</label>
                <input type="number" id="budget" name="budget" step="0.01" min="10" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>
                @error('budget')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
            <div>
                <label for="start_date" class="block text-gray-700 font-semibold mb-2">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>
                @error('start_date')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
        </div>
        
        <div class="mb-6">
            <label for="end_date" class="block text-gray-700 font-semibold mb-2">End Date</label>
            <input type="date" id="end_date" name="end_date" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>
            @error('end_date')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>
        
        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded font-semibold hover:bg-blue-700">Create Campaign</button>
            <a href="{{ route('advertiser.campaigns.index') }}" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded font-semibold hover:bg-gray-400 text-center">Cancel</a>
        </div>
    </form>
</div>
@endsection
