@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-600 text-sm font-semibold">Total Users</h3>
        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalUsers }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-600 text-sm font-semibold">Advertisers</h3>
        <p class="text-3xl font-bold text-green-600 mt-2">{{ $advertisers }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-600 text-sm font-semibold">Publishers</h3>
        <p class="text-3xl font-bold text-purple-600 mt-2">{{ $publishers }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-600 text-sm font-semibold">Pending Campaigns</h3>
        <p class="text-3xl font-bold text-orange-600 mt-2">{{ $pendingCampaigns }}</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-4">Management Tasks</h2>
        <ul class="space-y-3">
            <li><a href="{{ route('admin.users.index') }}" class="block bg-blue-50 p-3 rounded hover:bg-blue-100">Manage Users</a></li>
            <li><a href="{{ route('admin.campaigns.index') }}" class="block bg-yellow-50 p-3 rounded hover:bg-yellow-100">Review Campaigns</a></li>
            <li><a href="{{ route('admin.ads.index') }}" class="block bg-purple-50 p-3 rounded hover:bg-purple-100">Moderate Ads</a></li>
            <li><a href="{{ route('admin.withdrawals.index') }}" class="block bg-green-50 p-3 rounded hover:bg-green-100">Process Withdrawals</a></li>
        </ul>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-4">Platform Health</h2>
        <div class="space-y-3">
            <div><span class="text-gray-600">Users:</span> <span class="font-bold">{{ $totalUsers }}</span></div>
            <div><span class="text-gray-600">Active Campaigns:</span> <span class="font-bold">Checking...</span></div>
            <div><span class="text-gray-600">Total Impressions:</span> <span class="font-bold">0</span></div>
            <div><span class="text-gray-600">Total Clicks:</span> <span class="font-bold">0</span></div>
        </div>
    </div>
</div>
@endsection
