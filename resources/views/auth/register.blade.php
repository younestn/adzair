@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">Create Account</h2>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold mb-2">Full Name</label>
            <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>
            @error('name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>
        
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
            <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>
            @error('email')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>
        
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
            <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>
            @error('password')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>
        
        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>
        </div>
        
        <div class="mb-6">
            <label for="role" class="block text-gray-700 font-semibold mb-2">I am an</label>
            <select id="role" name="role" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>
                <option value="advertiser">Advertiser (Create campaigns)</option>
                <option value="publisher">Publisher (Monetize website)</option>
            </select>
            @error('role')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>
        
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded font-semibold hover:bg-blue-700">Register</button>
    </form>
    
    <p class="text-center mt-4 text-gray-600">Already have an account? <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Login</a></p>
</div>
@endsection
