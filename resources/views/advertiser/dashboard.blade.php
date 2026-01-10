@extends('layouts.app')

@section('title', 'Advertiser Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-600 text-sm font-semibold">Total Campaigns</h3>
        <p class="text-3xl font-bold text-blue-600 mt-2">{{ auth()->user()->campaigns()->count() }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-600 text-sm font-semibold">Active Campaigns</h3>
        <p class="text-3xl font-bold text-green-600 mt-2">{{ auth()->user()->campaigns()->where('status', 'active')->count() }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-600 text-sm font-semibold">Total Impressions</h3>
        <p class="text-3xl font-bold text-purple-600 mt-2">0</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-600 text-sm font-semibold">Total Clicks</h3>
        <p class="text-3xl font-bold text-orange-600 mt-2">0</p>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Your Campaigns</h2>
        <a href="{{ route('advertiser.campaigns.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Create Campaign</a>
    </div>
    
    @if(auth()->user()->campaigns()->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="border-b">
                    <tr>
                        <th class="py-3 font-semibold">Campaign Name</th>
                        <th class="py-3 font-semibold">Budget</th>
                        <th class="py-3 font-semibold">Status</th>
                        <th class="py-3 font-semibold">Duration</th>
                        <th class="py-3 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(auth()->user()->campaigns()->latest()->limit(5)->get() as $campaign)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3">{{ $campaign->name }}</td>
                            <td class="py-3">${{ number_format($campaign->budget, 2) }}</td>
                            <td class="py-3"><span class="px-3 py-1 rounded text-sm font-semibold {{ $campaign->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ ucfirst($campaign->status) }}</span></td>
                            <td class="py-3">{{ $campaign->start_date->format('M d') }} - {{ $campaign->end_date->format('M d') }}</td>
                            <td class="py-3"><a href="{{ route('advertiser.campaigns.show', $campaign) }}" class="text-blue-600 hover:text-blue-800">View</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500 text-center py-8">No campaigns yet. <a href="{{ route('advertiser.campaigns.create') }}" class="text-blue-600 hover:text-blue-800">Create one</a></p>
    @endif
</div>
@endsection
