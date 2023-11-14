<?php

use App\Http\Controllers\ClinicController;
use Illuminate\Support\Facades\Route;

Route::get('/list', [ClinicController::class, "list"])->name('clinics.list');
Route::get('/edit/{id}', [ClinicController::class, "edit"])->name('clinics.edit');
Route::get('/create', [ClinicController::class, "create"])->name('clinics.create');
Route::post("/paginate", [ClinicController::class, "paginate"])->name('clinics.paginate');

Route::post("/save", [ClinicController::class, "save"])->name("clinics.save");
Route::post("/verify", [ClinicController::class, "verify"])->name("clinics.verify");


