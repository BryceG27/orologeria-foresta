<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransportDocumentController;
use App\Http\Controllers\WorkingController;
use App\Http\Controllers\WorkshopController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect(route('dashboard'));
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('customers', CustomerController::class);

    Route::resource('workings', WorkingController::class);

    Route::resource('orders', OrderController::class);

    Route::resource('brands', BrandController::class);
    Route::put('brands/{brand}/restore', [BrandController::class, 'restore'])->name('brands.restore');

    Route::resource('workshops', WorkshopController::class);
    Route::resource('transport-documents', TransportDocumentController::class);
});

require __DIR__.'/auth.php';
