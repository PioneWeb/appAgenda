<?php

use App\Http\Controllers\ClinicController;
use Illuminate\Support\Facades\Route;

Route::get('/list', [ClinicController::class, "list"])->name('clinics.list');
Route::get('/edit/{id}', [ClinicController::class, "edit"])->name('clinics.edit');
Route::get('/search/{id}', [ClinicController::class, "search"])->name('clinics.search');
Route::get('/create', [ClinicController::class, "create"])->name('clinics.create');
Route::get('/associate/{id}/{doctor}', [ClinicController::class, "associate"])->name('clinics.associate');
Route::get('/dissociate/{id}/{doctor}', [ClinicController::class, "dissociate"])->name('clinics.dissociate');

Route::post("/paginate", [ClinicController::class, "paginate"])->name('clinics.paginate');
Route::post("/save", [ClinicController::class, "save"])->name("clinics.save");
Route::post("/verify", [ClinicController::class, "verify"])->name("clinics.verify");


