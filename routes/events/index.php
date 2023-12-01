<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/list', [EventController::class, "list"])->name('events.list');
Route::get('/test', [EventController::class, "test"])->name('events.test');
Route::get('/calendar', [EventController::class, "calendar"])->name('events.calendar');
//Route::get('/day/{dt}/{id}/{cl}', [EventController::class, "day"])->name('events.day');
//Route::get('/week/{inizio}/{fine}/{id}/{cl}', [EventController::class, "week"])->name('events.week');
//Route::get('/month/{id}/{ms}/{cl}', [EventController::class, "month"])->name('events.month');


Route::get('/edit/{id}', [EventController::class, "edit"])->name('events.edit');
Route::get('/create', [EventController::class, "create"])->name('events.create');
Route::post("/paginate", [EventController::class, "paginate"])->name('events.paginate');

Route::post("/save", [EventController::class, "save"])->name("events.save");


//Route::post('/saveEvent', [EventController::class, "saveEvent"])->name('note.saveEvent');
Route::post('/update/{id}', [EventController::class, "update"])->name('events.update');
//Route::delete('/delete/{id}', [EventController::class, "destroy"])->name('note.delete');
