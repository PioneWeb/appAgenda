<?php

use App\Http\Controllers\HomeController;
use App\Models\Company;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/genera/utente', function () {
    User::factory()->create();
})->name('utenti.genera');

Route::get('/genera/azienda', function () {
    Company::factory()->create();
})->name('companies.genera');

Route::get('/genera/ticket', function () {
    Ticket::factory()->create();
})->name('tickets.genera');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
//    Route::get('/', function () {
//        return Inertia::render('Welcome');
//    })->name('welcome');
//    Route::get('/home', function () {
//        return Inertia::render('Home');
//    })->name('home');

    Route::get('/home', [HomeController::class, "index"])->name('home');

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/modifica', function () {
        return Inertia::render('Modifica');
    })->name('modifica');


    Route::prefix('/companies')->group(fn () => Route::group([], __DIR__."/companies/index.php"));
    Route::prefix('/users')->group(fn () => Route::group([], __DIR__."/users/index.php"));
    Route::prefix('/tickets')->group(fn () => Route::group([], __DIR__."/tickets/index.php"));
    Route::prefix('/services')->group(fn () => Route::group([], __DIR__."/services/index.php"));
    Route::prefix('/tipitickets')->group(fn () => Route::group([], __DIR__."/tipitickets/index.php"));
    Route::prefix('/clinics')->group(fn () => Route::group([], __DIR__."/clinics/index.php"));
    Route::prefix('/prescriptions')->group(fn () => Route::group([], __DIR__ . "/prescriptions/index.php"));
    Route::prefix('/schedules')->group(fn () => Route::group([], __DIR__ . "/schedules/index.php"));
});
