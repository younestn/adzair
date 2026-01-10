<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Campaign;
use App\Models\Ad;
use App\Models\Website;
use App\Models\Earning;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@adzair.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create advertiser
        $advertiser = User::create([
            'name' => 'Sample Advertiser',
            'email' => 'advertiser@adzair.test',
            'password' => Hash::make('password'),
            'role' => 'advertiser',
            'email_verified_at' => now(),
        ]);

        // Create publisher
        $publisher = User::create([
            'name' => 'Sample Publisher',
            'email' => 'publisher@adzair.test',
            'password' => Hash::make('password'),
            'role' => 'publisher',
            'email_verified_at' => now(),
        ]);

        // Create sample campaign
        $campaign = Campaign::create([
            'user_id' => $advertiser->id,
            'name' => 'Summer Product Launch',
            'description' => 'Promote our new summer collection',
            'budget' => 5000,
            'spent' => 0,
            'start_date' => Carbon::today(),
            'end_date' => Carbon::today()->addDays(30),
            'status' => 'active',
            'approved_at' => now(),
            'approved_by' => $admin->id,
        ]);

        // Create sample ads
        Ad::create([
            'campaign_id' => $campaign->id,
            'type' => 'image',
            'image_url' => 'https://via.placeholder.com/300x250?text=Summer+Collection',
            'destination_url' => 'https://example.com/summer',
            'status' => 'active',
        ]);

        Ad::create([
            'campaign_id' => $campaign->id,
            'type' => 'text',
            'content' => 'Check out our amazing summer collection! Limited time offer.',
            'destination_url' => 'https://example.com/summer',
            'status' => 'active',
        ]);

        // Create sample website
        $website = Website::create([
            'user_id' => $publisher->id,
            'name' => 'Tech Blog',
            'url' => 'https://techblog.example.com',
            'category' => 'Technology',
            'status' => 'active',
            'snippet_code' => 'snippet_' . bin2hex(random_bytes(16)),
        ]);

        // Create sample earnings
        Earning::create([
            'user_id' => $publisher->id,
            'website_id' => $website->id,
            'ad_id' => null,
            'impressions' => 1500,
            'clicks' => 45,
            'amount' => 22.50,
            'period' => 'January 2024',
        ]);
    }
}
