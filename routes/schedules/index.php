<?php

use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/list', [ScheduleController::class, "list"])->name('schedules.list');
Route::get('/edit/{id}', [ScheduleController::class, "edit"])->name('schedules.edit');
Route::get('/create', [ScheduleController::class, "create"])->name('schedules.create');
Route::post("/paginate", [ScheduleController::class, "paginate"])->name('schedules.paginate');

Route::post("/save", [ScheduleController::class, "save"])->name("schedules.save");
Route::post("/sino", [ScheduleController::class, "sino"])->name("schedules.sino");


