<?php

namespace App\Http\Controllers;

use App\Models\Clinics;
use App\Models\Company;
use App\Models\Prescription;
use App\Models\Schedule;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        /** @var User $user */
        $user = auth()->user();
        /** @var Company $query */
        $aziende = Company::query()->count();
        /** @var User $query */
        $users = User::query()->count();

        $ambulatori = Clinics::query()->count();
        $Orari = Schedule::query()->count();
        $ricette = Prescription::query()->count();

        /** @var Event $appuntamenti */
        $appuntamenti = Event::query()->count();

        //if($user->can("company.list")) {
        return Inertia::render('Home', [
            "companies" => $aziende,
            "users" => $users,
            "ambulatori" => $ambulatori,
            "orari" => $Orari,
            "ricette" => $ricette,
            "appuntamenti" => $appuntamenti,
        ]);
    }
}
