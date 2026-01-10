@extends('layouts.app')

@section('title', $website->name)

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold">{{ $website->name }}</h1>
    <p class="text-gray-600 mt-2">{{ $website->url }}</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="text-gray-600 text-sm font-semibold">Impressions</h3>
        <p class="text-2xl font-bold text-blue-600 mt-2">{{ $impressions }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="text-gray-600 text-sm font-semibold">Clicks</h3>
        <p class="text-2xl font-bold text-green-600 mt-2">{{ $clicks }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="text-gray-600 text-sm font-semibold">Total Earnings</h3>
        <p class="text-2xl font-bold text-purple-600 mt-2">${{ number_format($earnings, 2) }}</p>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Ad Snippet</h2>
    <p class="text-gray-600 mb-4">Add this script to your website to display ads:</p>
    <div class="bg-gray-100 p-4 rounded font-mono text-sm overflow-x-auto">
        <code>&lt;script src="{{ url('/ad-server.js') }}?snippet={{ $snippet }}"&gt;&lt;/script&gt;</code>
    </div>
    <button onclick="navigator.clipboard.writeText('&lt;script src=\"{{ url('/ad-server.js') }}?snippet={{ $snippet }}\"&gt;&lt;/script&gt;')" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Copy Snippet</button>
</div>
@endsection
