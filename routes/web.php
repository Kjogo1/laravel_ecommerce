<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AdminAuthViewController;
use App\Http\Controllers\ProductController;
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

    Route::group([
        // 'prefix' => 'product',
        'as' => 'admin.'
    ], function() {
        Route::get('/product/archive', [ProductController::class, 'archive'])->name('product.archive');
        Route::get('/product/archive/{product}', [ProductController::class, 'archiveShow'])->name('product.archiveShow');
        Route::delete('/product/forceDelete/{product}', [ProductController::class, 'forceDelete'])->name('product.forceDelete');

        Route::resource('/product', ProductController::class);

    });
});

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
