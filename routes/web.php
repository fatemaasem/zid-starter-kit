<?php

use App\Http\Controllers\OAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/oauth/redirect', [OAuthController::class, 'redirect'])->name('oauth.redirect');
    Route::get('/oauth/callback', [OAuthController::class, 'callback'])->name('oauth.callback');
});

// Route to handle Zid webhooks
Route::post('/webhooks/zid', [WebhookController::class, 'handle'])->name('webhook.zid');


require __DIR__.'/auth.php';

