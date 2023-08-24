<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AdminAuthViewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::post('/adminLogin', [AdminAuthController::class, 'adminLogin'])->name('adminLogin');
Route::post('/adminRegister', [AdminAuthController::class, 'adminRegister'])->name('adminRegister');
Route::get('/adminLogout', [AdminAuthController::class, 'adminLogout'])->name('adminLogout');

// auth
Route::get('/adminLogin', [AdminAuthViewController::class, 'adminLogin'])->name('login');
Route::get('/adminRegister', [AdminAuthViewController::class, 'adminRegister'])->name('register');

Route::prefix('admin')->middleware(['auth', 'api', 'is_admin'])->group(function () {
    Route::get('/', [AdminAuthViewController::class, 'admin'])->name('admin.index');

    Route::prefix('product')->group(function() {
        Route::get('/', function() {
            return view('admin.dashboard.products.index');
        })->name('admin.product.index');
    });
});

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
