<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\TransactionController;
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
Route::get('/asset/search', [AssetController::class, 'search'])->name('asset.search');

Route::post('asset/{id}/requests', [AssetController::class, 'requestAsset'])->name('asset.requests');

Route::middleware('auth')->group(function () {
    // Route for viewing all requests (Admin)
    Route::get('requests', [RequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/{id}/edit', [RequestController::class, 'edit'])->name('requests.edit');
    Route::put('/requests/{id}', [RequestController::class, 'update'])->name('requests.update');

    // Routes for approving and rejecting requests (Admin)
    Route::post('requests/{id}/approve', [RequestController::class, 'approve'])->name('requests.approve');
    Route::post('requests/{id}/reject', [RequestController::class, 'reject'])->name('requests.reject');
    Route::post('requests/store', [RequestController::class, 'store'])->name('requests.store');
    // Route for viewing user's requests history
    Route::get('requests/history', [RequestController::class, 'userHistory'])->name('requests.history');
    Route::delete('requests/{id}', [RequestController::class, 'destroy'])->name('requests.destroy');
    Route::get('/requests/create', [RequestController::class, 'create'])->name('requests.create');
});
Route::get('/transactions/{id}/return', [TransactionController::class, 'returnForm'])->name('transactions.return');
Route::post('/transactions/{id}/return', [TransactionController::class, 'processReturn'])->name('transactions.processReturn');

Route::resource('transactions', TransactionController::class);
