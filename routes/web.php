<?php

use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ShortUrlController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;


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

require __DIR__.'/auth.php';

// Invitation Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/invitations', [InvitationController::class, 'index'])->name('invitations.index');
    Route::get('/invitations/create', [InvitationController::class, 'create'])->name('invitations.create');
    Route::post('/invitations', [InvitationController::class, 'store'])->name('invitations.store');
    Route::get('/invitations/accept/{token}', [InvitationController::class, 'accept'])->name('invitations.accept');
});

// Short URL Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/short-urls', [ShortUrlController::class, 'index'])->name('short-urls.index');
    Route::get('/short-urls/create', [ShortUrlController::class, 'create'])->name('short-urls.create');
    Route::post('/short-urls', [ShortUrlController::class, 'store'])->name('short-urls.store');
});

// Public route for redirecting short URLs
Route::get('/s/{code}', [ShortUrlController::class, 'redirect'])->name('short-urls.redirect');

