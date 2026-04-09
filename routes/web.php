<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', \App\Http\Controllers\UserController::class);
        Route::resource('categories', \App\Http\Controllers\CategoryController::class);
        Route::resource('equipment', \App\Http\Controllers\EquipmentController::class);
        Route::resource('borrowings', \App\Http\Controllers\BorrowingController::class);
        Route::get('report-borrowings', [\App\Http\Controllers\BorrowingController::class, 'report'])->name('borrowings.report');
        Route::get('activity-logs', [\App\Http\Controllers\ActivityLogController::class, 'index'])->name('activity-logs.index');
    });
    // User Routes
    Route::get('/katalog', [\App\Http\Controllers\UserPageController::class, 'catalog'])->name('user.catalog');
    Route::post('/pinjam', [\App\Http\Controllers\UserPageController::class, 'storeBorrow'])->name('user.borrow.store');
    Route::get('/riwayat', [\App\Http\Controllers\UserPageController::class, 'history'])->name('user.history');
    Route::patch('/kembalikan/{borrowing}', [\App\Http\Controllers\UserPageController::class, 'returnBorrow'])->name('user.borrow.return');
    
    // Chatbot Peminjam
    Route::get('/chatbot', [\App\Http\Controllers\ChatbotController::class, 'index'])->name('user.chatbot.index');
    Route::post('/chatbot/respond', [\App\Http\Controllers\ChatbotController::class, 'respond'])->name('user.chatbot.respond');
});

require __DIR__.'/auth.php';
