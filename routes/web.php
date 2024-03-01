<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BanqueController;
use App\Http\Controllers\CaisseController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ProfessorController;
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
Route::get('cv', function () {
    return view('cv.cv');
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
    Route::get('showListUser', [UserController::class, 'showListUser'])->name('showListUser');

    //post
    Route::post('getUserInfoById', [UserController::class, 'getUserInfoById']);
    Route::post('add_user', [UserController::class, "add_user"]);
    Route::post('update_user', [UserController::class, 'update_user']);
    Route::post('delete_user', [UserController::class, 'delete_user']);
    Route::post('updatePassword', [UserController::class, 'updatePassword']);
});

// manage school
Route::prefix('school')->middleware(['auth'])->group(function () {
    // Get
    Route::get('', [SchoolController::class, 'school'])->name('school');
    Route::get('showListSchool', [SchoolController::class, 'showListSchool'])->name('showListSchool');

    //post
    Route::post('getSchoolInfoById', [SchoolController::class, 'getSchoolInfoById']);
    Route::post('add', [SchoolController::class, "add"]);
    Route::post('update', [SchoolController::class, 'update']);
    Route::post('delete', [SchoolController::class, 'delete']);
});

// manage professor
Route::prefix('professor')->middleware(['auth'])->controller(ProfessorController::class)->group(function () {
    // Get
    Route::get('', 'professor')->name('professor');
    Route::get('showListProfessor', 'showListProfessor')->name('showListProfessor');

    //post
    Route::post('getProfessorInfoById', 'getProfessorInfoById');
    Route::post('add', "add");
    Route::post('update', 'update');
    Route::post('delete', 'delete');
});

// manage classrooom
Route::prefix('classroom')->middleware(['auth'])->controller(ClassroomController::class)->group(function () {
    // Get
    Route::get('','classroom')->name('classroom');
    Route::get('showListClassroom', 'showListClassroom')->name('showListClassroom');
    Route::get('edit/{id}', 'edit');
    Route::get('view/{id}', 'view');

    //post
    Route::post('getClassroomInfoById', 'getClassroomInfoById');
    Route::post('add', "add");
    Route::post('update', 'update');
    Route::post('delete', 'delete');
});

Route::post('outUser', [UserController::class, 'outUser'])->name('outUser');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
