<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/attendance', [userController::class, 'showAttendance'])->name('show.attendance');
});

Route::get('/attendance/mark', [userController::class, 'showMarkAttendance'])->name('show.markAttendance');
Route::post('/attendance/mark/{id}', [userController::class, 'storeAttendance'])->name('store.attendance');

Route::get('/users/{role?}', [userController::class, 'listUsers'])
        ->name('showAllUsers');

Route::get('/dashboard',[userController::class,'index'])->
middleware(['auth', 'verified'])->name('dashboard');

Route::get('/user-edit/{id}',[userController::class,'userEdit'])->name('userEdit');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
