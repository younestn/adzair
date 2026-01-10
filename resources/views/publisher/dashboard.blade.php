@extends('layouts.app')

@section('title', 'Publisher Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-600 text-sm font-semibold">Total Websites</h3>
        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $websites->count() }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-600 text-sm font-semibold">Total Earnings</h3>
        <p class="text-3xl font-bold text-green-600 mt-2">${{ number_format($totalEarnings, 2) }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-600 text-sm font-semibold">Pending Withdrawals</h3>
        <p class="text-3xl font-bold text-orange-600 mt-2">${{ number_format($pendingWithdrawals, 2) }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-600 text-sm font-semibold">Available Balance</h3>
        <p class="text-3xl font-bold text-purple-600 mt-2">${{ number_format($totalEarnings - $pendingWithdrawals, 2) }}</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Your Websites</h2>
            <a href="{{ route('publisher.websites.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Register Website</a>
        </div>
        @if($websites->count() > 0)
            <ul class="space-y-3">
                @foreach($websites as $website)
                    <li><a href="{{ route('publisher.websites.show', $website) }}" class="text-blue-600 hover:text-blue-800">{{ $website->name }}</a></li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No websites registered yet.</p>
        @endif
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-6">Quick Actions</h2>
        <div class="space-y-3">
            <a href="{{ route('publisher.earnings') }}" class="block bg-blue-50 p-4 rounded hover:bg-blue-100">View Earnings History</a>
            <a href="{{ route('publisher.withdrawal.create') }}" class="block bg-green-50 p-4 rounded hover:bg-green-100">Request Withdrawal</a>
            <a href="{{ route('publisher.websites') }}" class="block bg-gray-50 p-4 rounded hover:bg-gray-100">Manage Websites</a>
        </div>
    </div>
</div>
@endsection
