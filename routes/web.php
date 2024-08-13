<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function () {
    return redirect()->route('login'); // Redirect to login page
});

Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
Route::put('/category/{category}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

Route::get('/asset/create', [AssetController::class, 'create'])->name('asset.create');
Route::post('/asset', [AssetController::class, 'store'])->name('asset.store');
Route::get('/asset', [AssetController::class, 'index'])->name('asset.index');
Route::get('/asset/{asset}/edit', [AssetController::class, 'edit'])->name('asset.edit');
Route::put('/asset/{asset}', [AssetController::class, 'update'])->name('asset.update');
Route::delete('/asset/{asset}', [AssetController::class, 'destroy'])->name('asset.destroy');
