<?php

use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/list', [UsersController::class, "list"])->name('users.list');
Route::get('/usersList', [UsersController::class, "usersList"])->name('users.usersList');
Route::get('/ticketUsersList', [UsersController::class, "ticketUsersList"])->name('users.ticketUsersList');
Route::get('/edit/{id}', [UsersController::class, "edit"])->name('users.edit');
Route::get('/create', [UsersController::class, "create"])->name('users.create');
Route::post("/paginate", [UsersController::class, "paginate"])->name('users.paginate');

Route::post("/save", [UsersController::class, "save"])->name("users.save");
Route::post("/verify", [UsersController::class, "verify"])->name("users.verify");


