<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/list', [EventController::class, "list"])->name('events.list');


Route::get('/edit/{id}', [EventController::class, "edit"])->name('events.edit');
Route::get('/create', [EventController::class, "create"])->name('events.create');
Route::post("/paginate", [EventController::class, "paginate"])->name('events.paginate');

Route::post("/save", [EventController::class, "save"])->name("events.save");


Route::post('/day', [EventController::class, "day"])->name('events.day');
Route::post('/week', [EventController::class, "week"])->name('events.week');
Route::get('/month/{id}/{ms}/{cl}', [EventController::class, "month"])->name('events.month');
