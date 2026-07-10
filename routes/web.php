<?php

use App\Http\Controllers\DashboardController;
use App\Livewire\BookAppointment;
use App\Livewire\ListPrestations;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome')->name('welcome');

// Catalogue des prestations (accessible aux invités et aux connectés).
Route::get('/prestations', ListPrestations::class)->name('prestations.index');

/*
|--------------------------------------------------------------------------
| Routes authentifiées
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Redirection intelligente vers le bon tableau de bord selon le rôle.
    Route::get('/dashboard', DashboardController::class)
        ->middleware('verified')
        ->name('dashboard');

    // Profil (fourni par Breeze).
    Route::view('profile', 'profile')->name('profile');

    /*
    |--------------------------------------------------------------------------
    | Espace CLIENT
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:client')->group(function () {
        // Tunnel de réservation pour une prestation donnée.
        Route::get('/reservations/create/{prestation}', BookAppointment::class)
            ->name('reservations.create');

        // Mes réservations (consultation + annulation).
        Route::view('/mes-reservations', 'client.reservations')->name('mes-reservations');
    });

    /*
    |--------------------------------------------------------------------------
    | Espace ADMINISTRATEUR
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::view('/prestations', 'admin.prestations')->name('prestations');
        Route::view('/reservations', 'admin.reservations')->name('reservations');
        Route::view('/utilisateurs', 'admin.users')->name('users');
    });

    /*
    |--------------------------------------------------------------------------
    | Espace PRESTATAIRE
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:prestataire')->prefix('prestataire')->name('prestataire.')->group(function () {
        Route::view('/agenda', 'prestataire.agenda')->name('agenda');
    });
});

require __DIR__.'/auth.php';
