<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\FlatController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\BillCategoryController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\DashboardController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Multi-tenant protected routes
Route::middleware(['auth', 'multitenant'])->group(function () {

    // Building routes - accessible by both admin and house owners
    Route::resource('buildings', BuildingController::class);

    // Flat routes - accessible by both admin and house owners
    Route::resource('flats', FlatController::class);

    // Tenant routes - create/edit/delete only by admin, view by all
    Route::resource('tenants', TenantController::class);

    // Bill category routes - accessible by both admin and house owners
    Route::resource('bill-categories', BillCategoryController::class);

    // Bill routes - accessible by both admin and house owners
    Route::resource('bills', BillController::class);

    // Additional bill routes
    Route::post('bills/{id}/mark-as-paid', [BillController::class, 'markAsPaid'])->name('bills.mark-as-paid');
    Route::post('bills/generate-monthly', [BillController::class, 'generateMonthlyBills'])->name('bills.generate-monthly');
});

require __DIR__.'/auth.php';
