<?php

namespace App\Http\Controllers;

use App\Mail\TicketEmail;
use App\Models\Company;
use App\Models\Message;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\TicketUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Mail;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        /** @var User $user */
        $user = auth()->user();
        if($user->can("tickets.list")) {
            return Inertia::render('Tickets/List');
        }
        abort(403,"Non disponi dei permessi necessari!");
    }
    /**
     * @throws ValidationException
     */
    public function paginate(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("tickets.list")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        $this->validate($request,[
            "page" => "required|int|min:1",
            "pageSize" => "required|int|min:1",
            "search" => "nullable|string",
            "sort" => "nullable|string",
            "order" => "nullable|string|in:ascending,descending"
        ]);;
        $query = Ticket::with([
                "users",
                "customer.company",
                "customer",
                "service",
                "ticketType",
                "messages"
            ]);
        // RICERCHE CORRELATE
        if($user->company_id !== 1) {
            $query->where("customer_id",$user->id);
        }
        if(!empty($search = $request->input("search"))) {
            $query->where(function($query2) use ($search) {
                $query2->where("indirizzo", "like", '%'.$search.'%')
                       ->orWhere("telefono", "like", '%'.$search.'%')
                       ->orWhere("servizio", "like", '%'.$search.'%')
                       ->orWhere("note", "like", '%'.$search.'%');
            })->orderBy("data","desc")->orderBy("ora","desc");
        }
        return $query->paginate($request->input("pageSize"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function newTicket()
    {
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("tickets.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        $codice_random = bin2hex(openssl_random_pseudo_bytes(6));
        $codice_univoco = uniqid().$codice_random;
        /** @var Ticket $query */
        $query = Ticket::query()->where('id',0)->with([
            "user",
            "customer",
            "service",
            "ticketType",
            "messages" => ["user:id,name,profile_photo_path"]
        ])->first();
        return Inertia::render('Tickets/NewTicket', [
            "ticketProp" => $query,
            "codice_1" => $codice_random,
            "codice_2" => $codice_univoco,
        ]);

    }


    /**
     * Show the form for creating a new resource.
     */
    public function creaTicket(Request $request)
    {
        $this->validate($request,[
            "customer_id" => "required|int|min:1",
            "service_id" => "required|int|min:1",
            "ticket_type_id" => "required|int|min:1",
            "search" => "nullable|string",
            "sort" => "nullable|string",
            "order" => "nullable|string|in:ascending,descending"
        ]);
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("tickets.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        $codice_random = bin2hex(openssl_random_pseudo_bytes(6));
        $codice_univoco = uniqid().$codice_random;
        $oggettoTicket = [
            'ticket' => strtoupper(uniqid()),
            'data' => Carbon::now(),
            'ora' => Carbon::now(),
            'customer_id' => $request->input("customer_id"),
            'service_id' => $request->input("service_id"),
            'ticket_type_id' => $request->input("ticket_type_id"),
        ];
        //echo($oggettoTicket);
        /** @var Ticket $query */
        $ticket =  Ticket::create($oggettoTicket);

        return Inertia::render('Tickets/Edit', [
            "ticketProp" => $ticket,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) {
        /** @var User $user */
        $user = auth()->user();
        if($user->can("tickets.edit")) {
            $codice_random = bin2hex(openssl_random_pseudo_bytes(6));
            $codice_univoco = uniqid().$codice_random;
            /** @var Ticket $query */
            $query = Ticket::query()->where('id',$id)->with([
                "users",
                "customer",
                "service",
                "ticketType",
                "ticketUser.user",
                "messages" => ["user:id,name,profile_photo_path"],
            ])->first();
            return Inertia::render('Tickets/Edit', [
                "ticketProp" => $query,
//                "codice_1" => $codice_random,
//                "codice_2" => $codice_univoco,
            ]);
        }
        abort(403,"Non disponi dei permessi necessari!");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save(Request $request)
    {
        $this->validate($request,[
            "customer_id" => "required|int|min:1",
            "service_id" => "required|int|min:1",
            "ticket_type_id" => "required|int|min:1",
            "id" => "required|exists:tickets,id",
            "stato" => "nullable|boolean",
            "users_id" => "required|array"
        ]);
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("tickets.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        /** @var Ticket $ticket */
        $ticket = Ticket::where("id",$request->input("id"))->first();
        $oticket = [
            'customer_id' => $request->input("customer_id"),
            'service_id' => $request->input("service_id"),
            'ticket_type_id' => $request->input("ticket_type_id"),
            'stato' => $request->input("stato"),
        ];
        $ticket->update($oticket);
        $ticket->ticketUser()->delete();
        foreach ($request->input("users_id") as $ticketUser) {
            $oticketUsers = [
                'ticket_id' => $ticket->id,
                'user_id' => $ticketUser
            ];
            TicketUser::create($oticketUsers);
        }

        return response()->json([
            "id" => $ticket->id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function chiudiTicket(Request $request)
    {
        $this->validate($request,[
            "ticket_id" => "required|int|exists:tickets,id",
            "messaggio" => "nullable|string"
        ]);
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("tickets.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        /** @var Ticket $ticket */
        $ticket = Ticket::where("id",$request->input("ticket_id"))->first();
        $oticket = [
            "stato" => 0
        ];
        $ticket->update($oticket);
        return response()->json([
            "id" => $ticket->id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function comment(Request $request)
    {
        $this->validate($request,[
            "ticket_id" => "required|int|exists:tickets,id",
            "messaggio" => "nullable|string"
        ]);
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("tickets.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        $id = $request->input('ticket_id');
        $oggettoMessaggio = [
            "messaggio" => $request->input('messaggio'),
            "ticket_id" => $request->input('ticket_id'),
            "user_id" => $user->id,
            "created_at" => Carbon::now(),
        ];

        /** @var Message $message */
        $message = Message::create($oggettoMessaggio);
        $ticket = Ticket::with([
            "messages" => function ($q){
                $q->orderBy('id','DESC');
            },
            "messages.user",
            "service",
            "ticketType"
        ])->where("id",$id)->first();

        $email = "luca@s-mart.biz";

        Mail::to($email)->send(new TicketEmail(
            $ticket
        ));

        return response()->json([
            "id" => $id
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
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
