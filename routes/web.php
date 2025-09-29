<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\FlatController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\BillCategoryController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HouseOwnerController;
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
    return redirect()->route('login');
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

// Admin only routes
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin management routes
    Route::resource('admins', AdminController::class);

    // House Owner management routes
    Route::resource('house-owners', HouseOwnerController::class);

    // House Owner status management
    Route::post('house-owners/{houseOwner}/approve', [HouseOwnerController::class, 'approve'])->name('house-owners.approve');
    Route::post('house-owners/{houseOwner}/deactivate', [HouseOwnerController::class, 'deactivate'])->name('house-owners.deactivate');
    Route::post('house-owners/{houseOwner}/reactivate', [HouseOwnerController::class, 'reactivate'])->name('house-owners.reactivate');

    // Legacy user management routes (for backward compatibility)
    Route::resource('users', UserController::class);
    Route::post('users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
    Route::post('users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
    Route::post('users/{user}/reactivate', [UserController::class, 'reactivate'])->name('users.reactivate');
});

require __DIR__.'/auth.php';
