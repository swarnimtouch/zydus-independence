<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/certificate', [UserController::class, 'certificate'])->name('certificate');
