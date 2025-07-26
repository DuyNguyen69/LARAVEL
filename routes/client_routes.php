<?php

use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\GoogleController;
use App\Http\Controllers\Client\UserRentalController;
use Illuminate\Support\Facades\Route;

Route::view('/about', 'client.pages.about')->name('about');
Route::view('/contact', 'client.pages.contact')->name('contact');
Route::view('/services', 'client.pages.service')->name('services');
Route::view('/blog', 'client.pages.blog')->name('blog');
Route::view('/blog_single', 'client.pages.blog_single')->name('blog_single');

Route::get('/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
Route::middleware(['auth'])->group(function () {
    Route::get('/my-rentals', [UserRentalController::class, 'index'])->name('client.rentals.index');
});

Route::prefix('client')
    ->controller(ClientController::class)
    ->name('client.cars.')
    ->group(function () {
        Route::get('/home', 'index')->name('home');
        Route::get('/cars', 'show')->name('cars_list');
        Route::get('/booking', 'showBookingForm')->name('booking.form');
        Route::get('/{car}', 'detail')->name('detail');
        Route::post('/booking', 'submitBooking')->name('booking.submit');
    });
