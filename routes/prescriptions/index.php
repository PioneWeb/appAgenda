<?php

use App\Http\Controllers\PrescriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/list', [PrescriptionController::class, "list"])->name('prescriptions.list');
Route::get('/edit/{id}', [PrescriptionController::class, "edit"])->name('prescriptions.edit');
Route::get('/prescribe/{id}', [PrescriptionController::class, "prescribe"])->name('prescriptions.prescribe');
Route::get('/create', [PrescriptionController::class, "create"])->name('prescriptions.create');
Route::post("/paginate", [PrescriptionController::class, "paginate"])->name('prescriptions.paginate');

Route::post("/save", [PrescriptionController::class, "save"])->name("prescriptions.save");
Route::post("/verify", [PrescriptionController::class, "verify"])->name("prescriptions.verify");


