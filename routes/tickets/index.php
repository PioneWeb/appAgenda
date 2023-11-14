<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/list', [TicketController::class, "list"])->name('tickets.list');
Route::get('/edit/{id}', [TicketController::class, "edit"])->name('tickets.edit');
Route::get('/newTicket', [TicketController::class, "newTicket"])->name('tickets.newTicket');
Route::post('/creaTicket', [TicketController::class, "creaTicket"])->name('tickets.creaTicket');
Route::post('/chiudiTicket', [TicketController::class, "chiudiTicket"])->name('tickets.chiudiTicket');
Route::post("/paginate", [TicketController::class, "paginate"])->name('tickets.paginate');
Route::post("/save", [TicketController::class, "save"])->name('tickets.save');
Route::post("/comment", [TicketController::class, "comment"])->name('tickets.comment');
