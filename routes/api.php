<?php

use App\Http\Controllers\AdServerController;
use Illuminate\Support\Facades\Route;

Route::prefix('ads')->name('ads.')->group(function () {
    Route::get('serve', [AdServerController::class, 'serve'])->name('serve');
    Route::post('track/impression', [AdServerController::class, 'trackImpression'])->name('track.impression');
    Route::post('track/click', [AdServerController::class, 'trackClick'])->name('track.click');
});
