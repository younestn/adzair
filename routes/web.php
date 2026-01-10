<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'store']);
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'authenticate']);
});

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isAdvertiser()) {
            return redirect()->route('advertiser.dashboard');
        } else {
            return redirect()->route('publisher.dashboard');
        }
    })->name('dashboard');

    Route::prefix('advertiser')->name('advertiser.')->middleware('advertiser')->group(function () {
        Route::get('dashboard', function () {
            return view('advertiser.dashboard');
        })->name('dashboard');
        Route::resource('campaigns', CampaignController::class);
        Route::post('campaigns/{campaign}/toggle', [CampaignController::class, 'toggle'])->name('campaigns.toggle');
        Route::resource('ads', AdController::class)->only(['create', 'store', 'destroy']);
        Route::post('ads/{ad}/create/{campaign}', [AdController::class, 'create'])->name('ads.create');
    });

    Route::prefix('publisher')->name('publisher.')->middleware('publisher')->group(function () {
        Route::get('dashboard', [PublisherController::class, 'dashboard'])->name('dashboard');
        Route::get('websites', [PublisherController::class, 'websites'])->name('websites');
        Route::get('websites/create', [PublisherController::class, 'createWebsite'])->name('websites.create');
        Route::post('websites', [PublisherController::class, 'storeWebsite'])->name('websites.store');
        Route::get('websites/{website}', [PublisherController::class, 'showWebsite'])->name('websites.show');
        Route::get('earnings', [PublisherController::class, 'earnings'])->name('earnings');
        Route::get('withdrawal', [PublisherController::class, 'requestWithdrawal'])->name('withdrawal.create');
        Route::post('withdrawal', [PublisherController::class, 'storeWithdrawal'])->name('withdrawal.store');
    });

    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('users', [AdminController::class, 'users'])->name('users.index');
        Route::get('campaigns', [AdminController::class, 'campaigns'])->name('campaigns.index');
        Route::post('campaigns/{campaign}/approve', [AdminController::class, 'approveCampaign'])->name('campaigns.approve');
        Route::post('campaigns/{campaign}/reject', [AdminController::class, 'rejectCampaign'])->name('campaigns.reject');
        Route::get('ads', [AdminController::class, 'ads'])->name('ads.index');
        Route::post('ads/{ad}/approve', [AdminController::class, 'approveAd'])->name('ads.approve');
        Route::post('ads/{ad}/reject', [AdminController::class, 'rejectAd'])->name('ads.reject');
        Route::get('withdrawals', [AdminController::class, 'withdrawals'])->name('withdrawals.index');
        Route::post('withdrawals/{withdrawal}/approve', [AdminController::class, 'approveWithdrawal'])->name('withdrawals.approve');
        Route::post('withdrawals/{withdrawal}/reject', [AdminController::class, 'rejectWithdrawal'])->name('withdrawals.reject');
    });
});
