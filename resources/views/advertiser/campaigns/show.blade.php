@extends('layouts.app')

@section('title', $campaign->name)

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold">{{ $campaign->name }}</h1>
            <p class="text-gray-600 mt-2">{{ $campaign->description }}</p>
        </div>
        <div>
            <span class="inline-block px-4 py-2 rounded text-white font-semibold {{ $campaign->status === 'active' ? 'bg-green-600' : 'bg-yellow-600' }}">{{ ucfirst($campaign->status) }}</span>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-gray-600 text-sm font-semibold">Budget</h3>
            <p class="text-2xl font-bold text-blue-600 mt-2">${{ number_format($campaign->budget, 2) }}</p>
            <p class="text-sm text-gray-500">Spent: ${{ number_format($campaign->spent, 2) }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-gray-600 text-sm font-semibold">Impressions</h3>
            <p class="text-2xl font-bold text-purple-600 mt-2">{{ $impressionCount }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-gray-600 text-sm font-semibold">Clicks</h3>
            <p class="text-2xl font-bold text-orange-600 mt-2">{{ $clickCount }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-gray-600 text-sm font-semibold">CTR</h3>
            <p class="text-2xl font-bold text-green-600 mt-2">{{ number_format($ctr, 2) }}%</p>
        </div>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Ads</h2>
        <a href="{{ route('advertiser.ads.create', $campaign) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Add Ad</a>
    </div>
    
    @if($ads->count() > 0)
        <div class="space-y-4">
            @foreach($ads as $ad)
                <div class="border rounded p-4 flex justify-between items-start">
                    <div>
                        <h3 class="font-semibold">{{ ucfirst($ad->type) }} Ad</h3>
                        @if($ad->type === 'text')
                            <p class="text-gray-600 mt-1">{{ $ad->content }}</p>
                        @else
                            <p class="text-gray-600 mt-1">{{ $ad->image_url }}</p>
                        @endif
                        <p class="text-sm text-gray-500 mt-2">Link: {{ $ad->destination_url }}</p>
                    </div>
                    <form method="POST" action="{{ route('advertiser.ads.destroy', $ad) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Delete this ad?')">Delete</button>
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500 text-center py-8">No ads yet. <a href="{{ route('advertiser.ads.create', $campaign) }}" class="text-blue-600 hover:text-blue-800">Add one</a></p>
    @endif
</div>
@endsection
