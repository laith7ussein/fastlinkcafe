<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuAppearanceController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MenuController::class, 'index'])->name('menu');

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::middleware('guest')->group(function (): void {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('login.store');
    });

    Route::middleware(['auth', 'admin'])->group(function (): void {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('menu-items', MenuItemController::class)->except(['show']);
        Route::get('menu-appearance', [MenuAppearanceController::class, 'edit'])->name('menu-appearance.edit');
        Route::put('menu-appearance', [MenuAppearanceController::class, 'update'])->name('menu-appearance.update');
    });
});
