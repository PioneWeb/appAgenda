<?php

namespace App\Http\Controllers;

use App\Models\Clinics;
use App\Models\Company;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        /** @var User $user */
        $user = auth()->user();
        /** @var Event $appuntamenti */
        $appuntamenti = Event::all();
//        if(!$user->can("company.list")) {
//            abort(403,"Non disponi dei permessi necessari!");
//        }
        return Inertia::render('Events/List', [
            "appuntamenti" => $appuntamenti,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function day(Request $request)
    {
        $this->validate($request,[
            "page" => "required|int|min:1",
            "pageSize" => "required|int|min:1",
            "search" => "nullable|string",
            "sort" => "nullable|string",
            "order" => "nullable|string|in:ascending,descending",
            "data" => "nullable|date",
            "doctor_id" => "nullable|int|exists:users,id",
            "clinic_id" => "nullable|int|exists:clinics,id"
        ]);;

        /** @var User $user */
        $user = auth()->user();
        /** @var Event $appuntamenti */
        $appuntamenti = Event::where('data',$request->input("data"))->
        where('doctor_id',$request->input("doctor_id"))->
        where('clinic_id',$request->input("clinic_id"));
//        if(!$user->can("company.list")) {
//            abort(403,"Non disponi dei permessi necessari!");
//        }
        $appuntamenti->with(['patient','doctor','clinic']);
        return $appuntamenti->get();

    }

    /**
     * Display a listing of the resource.
     */
    public function week(Request $request)
    {
        $this->validate($request,[
            "page" => "required|int|min:1",
            "pageSize" => "required|int|min:1",
            "search" => "nullable|string",
            "sort" => "nullable|string",
            "order" => "nullable|string|in:ascending,descending",
            "inizio" => "nullable|date",
            "fine" => "nullable|date",
            "doctor_id" => "nullable|int|exists:users,id",
            "clinic_id" => "nullable|int|exists:clinics,id"
        ]);;

        /** @var User $user */
        $user = auth()->user();
        /** @var Event $appuntamenti */
        $appuntamenti = Event::where('data','>=',$request->input("inizio"))
            ->where('data','<=',$request->input("fine"))
            ->where('doctor_id',$request->input("doctor_id"))
            ->where('clinic_id',$request->input("clinic_id"));
//        if(!$user->can("company.list")) {
//            abort(403,"Non disponi dei permessi necessari!");
//        }
        $appuntamenti->with(['patient','doctor','clinic']);
        return $appuntamenti->get();
    }

    /**
     * Display a listing of the resource.
     */
    public function month($id,$ms,$cl): \Inertia\Response
    {
        /** @var User $user */
        $user = auth()->user();
//        if(!$user->can("company.list")) {
//            abort(403,"Non disponi dei permessi necessari!");
//        }
        //echo($ms);
        /** @var Event $appuntamenti */
        $appuntamenti = Event::with(['patient','doctor','clinic'])->whereMonth('data',$ms)->where('doctor_id',$id)->where('clinic_id',$cl)->get();;


        return Inertia::render('Events/Month', [
            "appuntamentiProp" => $appuntamenti
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(event $event)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
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

//        if(!$user->can("clinics.list")) {
//            abort(403,"Non disponi dei permessi necessari!");
//        }

        /** @var Event $query */
        $query = Event::query();

        // RICERCHE CORRELATE
        if(!empty($search = $request->input("search"))) {
            $query->where(function($query2) use ($search) {
                $query2->where("email","like",'%'.$search.'%')
                    ->orWhere("name", "like", '%'.$search.'%');
            });
        }
        $query->with(['patient','doctor','clinic']);

        // PAGINAZIONE
        return $query->paginate($request->input("pageSize"));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(event $event)
    {
        //
    }
}
