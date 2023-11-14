<?php

use App\Http\Controllers\TicketTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/list', [TicketTypeController::class, "list"])->name('tipitickets.list');
Route::get('/ticketTypeList', [TicketTypeController::class, "ticketTypeList"])->name('tipitickets.ticketTypeList');
Route::get('/edit/{id}', [TicketTypeController::class, "edit"])->name('tipitickets.edit');
Route::get('/create', [TicketTypeController::class, "create"])->name('tipitickets.create');

Route::post("/save", [TicketTypeController::class, "save"])->name("tipitickets.save");
Route::post("/paginate", [TicketTypeController::class, "paginate"])->name('tipitickets.paginate');
