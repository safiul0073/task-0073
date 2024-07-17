<?php

use App\Http\Controllers\BonusController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\RegistrationController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WebhookController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// webhook routes
Route::post('/webhook/stripe', WebhookController::class)
->withoutMiddleware(VerifyCsrfToken::class);

// referrer routes
Route::get('join', [RegistrationController::class, 'referrer_link'])->name('join.referrer');
Route::post('refer-register', [RegistrationController::class, 'store'])->name('user.register');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // user routes
    Route::resource('referrers', UserController::class)->only(['index', 'show']);
    Route::resource('gifts', BonusController::class)->only(['index','create','store']);

    // payement routes
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.page');
    Route::post('/wallet/add-money', [WalletController::class, 'processPayment'])->name('wallet.add.money');

});

require __DIR__.'/auth.php';
