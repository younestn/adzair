<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdZair - Advertising Platform</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100">
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="font-bold text-2xl text-blue-600">AdZair</span>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-800">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-800">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Welcome to AdZair</h1>
            <p class="text-xl text-gray-600 mb-8">Your complete advertising platform for reaching audiences and earning revenue</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold mb-4 text-blue-600">For Advertisers</h3>
                    <p class="text-gray-600 mb-4">Create targeted campaigns, upload ads, and track performance in real-time</p>
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Get Started →</a>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold mb-4 text-green-600">For Publishers</h3>
                    <p class="text-gray-600 mb-4">Monetize your website, earn from impressions and clicks, request payouts anytime</p>
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Get Started →</a>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold mb-4 text-purple-600">Features</h3>
                    <p class="text-gray-600 mb-4">Smart ad rotation, click tracking, real-time analytics, secure payments</p>
                    <span class="text-gray-400 font-semibold">Explore Platform →</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
