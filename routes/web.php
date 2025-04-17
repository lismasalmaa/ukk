<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});


Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['isAdmin', 'isLogin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'adminPage'])->name('home');

    Route::controller(ProductController::class)->prefix('product')->name('product.')->group(function () {
        Route::get('/', 'indexAdmin')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/updateEdit/{id}', 'updateEdit')->name('updateEdit');
        Route::put('/updateStock/{id}', 'updateStock')->name('updateStock');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    Route::controller(SaleController::class)->prefix('sale')->name('sale.')->group(function () {
        Route::get('/', 'indexAdmin')->name('index');
        Route::get('/exportExcel', 'exportExcel')->name('exportExcel');
    });

    Route::controller(UserController::class)->prefix('user')->name('user.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
});

Route::middleware(['isEmployee', 'isLogin'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'employeePage'])->name('home');

    Route::get('/product', [ProductController::class, 'indexEmployee'])->name('product');

    Route::controller(SaleController::class)->prefix('sale')->name('sale.')->group(function () {
        Route::get('/', 'indexEmployee')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::post('/paymentProccess', 'paymentProccess')->name('paymentProccess');
        Route::get('/member/{id}', 'member')->name('member');
        Route::get('/print/{id}', 'print')->name('print');
        Route::put('/updateSale/{id}', 'updateSale')->name('updateSale');
        Route::get('/exportExcel', 'exportExcel')->name('exportExcel');
<<<<<<< HEAD
        Route::get('/exportExcel/filter', 'exportFilterExcel')->name('exportExcelFiltered');
=======
>>>>>>> 01f517eb54fb37af3f3c289602eeca206ab7c229
        Route::post('/importExcel', 'importExcel')->name('importExcel');
        Route::get('/exportPDF/{id}', 'exportPDF')->name('exportPDF');
    });
});

Route::middleware(['isGuest'])->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

