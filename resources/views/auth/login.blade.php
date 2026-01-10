@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
    
    <form method="POST" action="{{ route('authenticate') }}">
        @csrf
        
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
            <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required value="{{ old('email') }}">
            @error('email')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>
        
        <div class="mb-6">
            <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
            <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>
            @error('password')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>
        
        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="remember" class="mr-2">
                <span class="text-gray-700">Remember me</span>
            </label>
        </div>
        
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded font-semibold hover:bg-blue-700">Login</button>
    </form>
    
    <p class="text-center mt-4 text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800">Register here</a></p>
</div>
@endsection
