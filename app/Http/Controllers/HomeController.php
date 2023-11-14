<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        /** @var User $user */
        $user = auth()->user();
        /** @var Company $query */
        $aziende = Company::query()->count();
        /** @var User $query */
        $users = User::query()->count();
        /** @var Ticket $query */
        $ticket = Ticket::query()->count();
        $ticketClosed = Ticket::query()->where("stato",0)->count();
        /** @var Service $query */
        $service = Service::query()->count();
        $aziendeService = Service::select('company_id')->distinct('company_id')->get();
        /** @var TicketType $tipiTickets */
        $tipiTickets = TicketType::query()->count();

        //if($user->can("company.list")) {
        return Inertia::render('Home', [
            "companies" => $aziende,
            "users" => $users,
            "tickets" => $ticket,
            "ticketClosed" => $ticketClosed,
            "service" => $service,
            "aziendeService" => $aziendeService,
            "tipiTickets" => $tipiTickets,
        ]);
    }
}
