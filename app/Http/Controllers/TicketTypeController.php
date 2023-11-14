<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Service;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class TicketTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list(): \Inertia\Response
    {
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("tipiTickets.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        /** @var Service $query */
        $service = TicketType::all('*');
            return Inertia::render('TipiTickets/List', [
                "tipitickets" => $service,
            ]);
    }

    public function ticketTypeList()
    {
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("tipiTickets.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        /** @var TicketType $ticketType */
        if($user->company_id !== 1) {
            $ticketType = TicketType::where("company_id",$user->company_id)->get();
        }else{
            $ticketType = TicketType::all('id','nome');
        }
        return $ticketType;
    }

    /**
     * Show the form for creating a new resource.
     * @throws ValidationException
     */
    public function paginate(Request $request)
    {
        $this->validate($request,[
            "page" => "required|int|min:1",
            "pageSize" => "required|int|min:1",
            "search" => "nullable|string",
            "sort" => "nullable|string",
            "order" => "nullable|string|in:ascending,descending"
        ]);;

        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("tipiTickets.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
            /** @var TicketType $query */
            $query = TicketType::query()->with("company:id,ragione_sociale");
            if($user->company_id !== 1) {
                $query->where("company_id",$user->company_id);
            }
            // RICERCHE CORRELATE
            if(!empty($search = $request->input("search"))) {
                $query->where(function($query2) use ($search) {
                    $query2->where("name","like",'%'.$search.'%')
                        ->orWhere("priority", "like", '%'.$search.'%');
                });
            }
            // PAGINAZIONE
            return $query->paginate($request->input("pageSize"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        Validator::validate([
            "id" => $id
        ], [
            "id" => "required|int|min:0"
        ]);
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("tipiTickets.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
            /** @var TicketType $tipiTickets */
            $tipiTickets = TicketType::query()->where("id",$id)->first();
            /** @var Company $aziende */
            if($user->company_id === 1) {
                $aziende = Company::query()->get();
            }else{
                $aziende = Company::where("id",$user->company_id)->first();
            }

            return Inertia::render('TipiTickets/Edit', [
                "idAzienda" => session()->has("idAzienda") ? session()->get("idAzienda") : null,
                "tipiTicketsProp" => $tipiTickets,
                "aziendeProp" => $aziende
            ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("tipiTickets.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        /** @var Company $query */
        if($user->company_id === 1) {
            $aziende = Company::query()->get();
        }else{
            $aziende = Company::where("id",$user->company_id)->first();
        }
        /** @var TicketType $tipiTickets */
        $tipiTickets = TicketType::where("id",0)->first();
            return Inertia::render('TipiTickets/Edit', [
                "tipiTicketsProp" => $tipiTickets,
                "aziendeProp" => $aziende
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save(Request $request)
    {
        Validator::validate($request->all(), [
            "id" => "nullable|integer",
            "nome" => "required|string",
            "priority" => "nullable|integer|min:1"
        ]);
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("tipiTickets.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        /** @var TicketType $ticketTyoe */
        $ticketType = TicketType::where("id",$request->input("id"))->first();

        $oggettoTicketType = [
            'nome' => $request->input('nome'),
            'company_id' =>  $user->company_id,
            'priority' => $request->input('priority')
        ];
        if(empty($request->input("id"))) {
            $ticketType = TicketType::create($oggettoTicketType);
        } else {
            $ticketType->update($oggettoTicketType);
        }
        return response()->json([
            "id" => $ticketType->id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ticketType $ticket_type)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ticketType $ticket_type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ticketType $ticket_type)
    {
        //
    }
}
