<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BanqueController;
use App\Http\Controllers\CaisseController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SousCaisseController;
use App\Http\Controllers\TypeDepenseController;

Route::get('', function () {
    return view('auth.login');
    // if($User->count() == 0){
    //     return view('auth.register');
    // }else{
    //     if (Auth::check()) {
    //         return view('accueil');
    //     }else{
    //         return view('auth.login');
    //     }
    // }
});

Route::post('ajouter_admin', [UserController::class, "ajouter_admin"])->name('ajouter_admin');

Route::get('connexion', function () {
    return view('auth.login');
})->name('conn');

Route::get('accueil', function () {
    return view('accueil');
})->middleware('auth')->name('tableau');

// pays
Route::prefix('pays')->middleware(['auth'])->group(function () {
    // Get
    Route::get('', [PaysController::class, 'pays'])->name('pays');

    //post
    Route::post('ajouterPays', [PaysController::class, 'ajouterPays']);
    Route::post('updatePays', [PaysController::class, 'update']);
    Route::post('deletePays', [PaysController::class, 'delete']);
});

// user
Route::prefix('utilisateurs')->middleware(['auth'])->group(function () {
    // Get
    Route::get('', [UserController::class, 'user'])->name('user');
    Route::get('profil', [UserController::class, 'profil'])->name('profil');

    //post
    Route::post('ajouter', [UserController::class, "ajouter"]);
    Route::post('ajouter_admin', [UserController::class, "ajouter_admin"]);
    Route::post('update', [UserController::class, 'update']);
    Route::post('parametre', [UserController::class, 'parametre']);
    Route::post('connected', [UserController::class, 'connected']);
    Route::post('status', [UserController::class, 'status']);
    Route::post('delete', [UserController::class, 'delete']);
    Route::post('updatePassword', [UserController::class, 'updatePassword']);
});

Route::post('outUser', [UserController::class, 'outUser'])->name('outUser');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
