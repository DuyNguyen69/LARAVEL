<?php

use App\Http\Controllers\admin\RentalController;
use App\Http\Controllers\Client\GoogleController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Middleware\CheckIsAdmin;
use Illuminate\Support\Facades\Route;

// Route::get('/admin/home',function(){
//     return view('admin.pages.dashboard');
// });
// Route::get('/admin/create',function(){
//     return view('admin.pages.vehicle.create');
// });

Route::prefix('admin/vehicle')
    ->controller(VehicleController::class)
    ->name('admin.vehicle.')
    ->middleware(CheckIsAdmin::class)
    ->group(function () {
        Route::get('create', 'create')->name('create');
        Route::get('index', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::post('destroy/{car}', 'destroy')->name('destroy');
        Route::get('detail/{car}', 'detail')->name('detail');
        Route::post('update/{car}', 'update')->name('update');
        Route::post('restore/{car}', 'restore')->name('restore');
        Route::get('trash', 'trash')->name('trash');
        Route::delete('force-delete/{car}', 'forceDelete')->name('forceDelete');
    });

Route::prefix('admin')
    ->controller(RentalController::class)
    ->name('admin.rentals.')
    ->middleware(CheckIsAdmin::class)
    ->group(function () {
        Route::get('rentals', 'index')->name('index');
        Route::put('rentals/{rental}/confirm', 'confirm')->name('confirm');
        Route::get('rentals/{rental}/detail', 'detail')->name('detail');
        Route::put('rentals/{rental}','update')->name('update');
        Route::get('rentals/{rental}/payment', 'payment')->name('payment');
        Route::post('rentals/{rental}/calculate-total', 'calculateTotalAjax')->name('calculateTotal');
        Route::put('rentals/{rental}/payment', 'markAsPaid')->name('markAsPaid');
        Route::put('rentals/{rental}/cancel', 'cancel')->name('cancel');
    });
