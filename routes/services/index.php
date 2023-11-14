<?php

use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/list', [ServiceController::class, "list"])->name('services.list');
Route::get('/serviceList', [ServiceController::class, "serviceList"])->name('service.serviceList');
Route::get('/edit/{id}', [ServiceController::class, "edit"])->name('services.edit');
Route::get('/create', [ServiceController::class, "create"])->name('services.create');

Route::post("/save", [ServiceController::class, "save"])->name("services.save");
Route::post("/paginate", [ServiceController::class, "paginate"])->name('services.paginate');
