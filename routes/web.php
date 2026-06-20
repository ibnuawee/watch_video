<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\Admin\AccessRequestController as AdminAccessRequestController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\VideoController as CustomerVideoController;
use App\Http\Controllers\Customer\RequestController as CustomerRequestController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('customer.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('/customers', AdminCustomerController::class);
        Route::resource('/categories', AdminCategoryController::class);
        Route::resource('/videos', AdminVideoController::class);

        Route::get('/access-requests', [AdminAccessRequestController::class, 'index'])->name('access-requests.index');
        Route::get('/access-requests/{accessRequest}', [AdminAccessRequestController::class, 'show'])->name('access-requests.show');
        Route::post('/access-requests/{accessRequest}/approve', [AdminAccessRequestController::class, 'approve'])->name('access-requests.approve');
        Route::post('/access-requests/{accessRequest}/reject', [AdminAccessRequestController::class, 'reject'])->name('access-requests.reject');
    });

Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

        Route::get('/videos', [CustomerVideoController::class, 'index'])->name('videos.index');
        Route::get('/videos/{video}', [CustomerVideoController::class, 'show'])->name('videos.show');
        Route::post('/videos/{video}/request-access', [CustomerVideoController::class, 'requestAccess'])->name('videos.request-access');
        Route::get('/videos/{video}/watch', [CustomerVideoController::class, 'watch'])->name('videos.watch');
        Route::get('/videos/{video}/stream', [CustomerVideoController::class, 'stream'])->name('videos.stream');

        Route::get('/requests', [CustomerRequestController::class, 'index'])->name('requests.index');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
