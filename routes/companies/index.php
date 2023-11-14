<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

Route::get('/list', [CompanyController::class, "list"])->name('companies.list');
Route::get('/companyList', [CompanyController::class, "companyList"])->name('companies.companyList');
Route::get('/edit/{id}', [CompanyController::class, "edit"])->name('companies.edit');
Route::post("/paginate", [CompanyController::class, "paginate"])->name('companies.paginate');

Route::post("/save", [CompanyController::class, "save"])->name("companies.save");
