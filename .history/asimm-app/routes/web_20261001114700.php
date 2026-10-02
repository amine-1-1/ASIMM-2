<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AuthController;



Route::middleware('auth')->group(function () {

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//Profil
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});
// Connexion administrateur
Route ::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

// Déconnexion administrateur
Route::post('logout', [AuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Pages protégées : il faut être connecté ET administrateur
Route::middleware(['auth', 'admin'])->group(function () {
    Route::middleware(['auth', 'admin'])->group(function () {
    Route::redirect('/', 'admin/users')->name('index');

    // Liste, modification et suppression des utilisateurs
    Route::get('users', [userController::class, 'index'])->name('users.index');
    Route::get('users/{id}', [userController::class, 'edit'])->name('users.edit');
    Route::put('users/{id}', [userController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [userController::class, 'destroy'])->name('users.destroy');
    });
});

require


