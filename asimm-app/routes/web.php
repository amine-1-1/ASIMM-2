<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Pages des membres connectés
Route::middleware('auth')->group(function () {
    // Tableau de bord
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
     // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
      Route::redirect('/','/admin/events');
    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Espace administration : toutes les URL commencent par /admin et les noms par "admin."
Route::prefix('admin')->name('admin.')->group(function () {

    // Connexion admin, accessible seulement aux visiteurs non connectés
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'create'])->name('login');
        // Limité à 5 tentatives par minute contre les attaques par force brute
        Route::post('login', [AuthController::class, 'store'])
            ->middleware('throttle:5,1')
            ->name('login.store');

    });

    // Déconnexion admin
    Route::post('logout', [AuthController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');

    // Pages protégées : il faut être connecté ET administrateur
    Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
    });
});

require __DIR__.'/auth.php';
