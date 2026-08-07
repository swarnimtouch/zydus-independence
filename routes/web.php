<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', [UserController::class, 'create'])->name('form.create');

Route::post('/form', [UserController::class, 'store'])->name('form.store');
