<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', [UserController::class, 'create'])->name('form.create');

Route::post('/form', [UserController::class, 'store'])->name('form.store');

Route::get('/second', [UserController::class, 'second'])->name('second');

Route::get('/third', [UserController::class, 'third'])->name('third');

Route::get('/activity', [UserController::class, 'activity'])->name('activity');

Route::get('/atorva/gold', [UserController::class, 'atorvaGold'])->name('atorva.gold');

Route::get('/generate-certificate', [UserController::class, 'generateCertificate'])->name('certificate.generate');

Route::post('/generate-certificate', [UserController::class, 'storeCertificatePhoto'])->name('certificate.photo.store');

Route::get('/certificate', [UserController::class, 'certificate'])->name('certificate');

Route::get('/certificate/download', [UserController::class, 'downloadCertificate'])->name('certificate.download');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.store');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::middleware('admin.auth')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/export', [AdminController::class, 'export'])->name('export');
        Route::get('/users/{user}/certificate/download', [AdminController::class, 'downloadCertificate'])->name('certificate.download');
        Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
    });
});
