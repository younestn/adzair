@extends('layouts.app')

@section('title', 'Register Website')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6">Register Your Website</h2>
    
    <form method="POST" action="{{ route('publisher.websites.store') }}">
        @csrf
        
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold mb-2">Website Name</label>
            <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>
            @error('name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>
        
        <div class="mb-4">
            <label for="url" class="block text-gray-700 font-semibold mb-2">Website URL</label>
            <input type="url" id="url" name="url" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>
            @error('url')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>
        
        <div class="mb-6">
            <label for="category" class="block text-gray-700 font-semibold mb-2">Category</label>
            <input type="text" id="category" name="category" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" placeholder="e.g., Technology, Lifestyle, News" required>
            @error('category')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>
        
        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded font-semibold hover:bg-blue-700">Register Website</button>
            <a href="{{ route('publisher.dashboard') }}" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded font-semibold hover:bg-gray-400 text-center">Cancel</a>
        </div>
    </form>
</div>
@endsection
