<?php

namespace App\Http\Controllers;

use App\Models\Clinics;
use App\Models\Company;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
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
        /** @var Clinics $ambulatori */
        $ambulatori = Clinics::all('id AS value','nome AS label');
        /** @var User $medici */
        $medici = User::select('id AS value','name AS label')->where('user_type_id',2)->get();
        /** @var Event $appuntamenti */
        $appuntamenti = Event::all();
//        if(!$user->can("company.list")) {
//            abort(403,"Non disponi dei permessi necessari!");
//        }
        return Inertia::render('Events/List', [
            "ambulatori" => $ambulatori,
            "medici" => $medici
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function day($dt,$id,$cl): \Inertia\Response
    {
        /** @var User $user */
        $user = auth()->user();
        /** @var Clinics $ambulatori */
        $ambulatori = Clinics::all('id AS value','nome AS label');
        /** @var User $medici */
        $medici = User::select('id AS value','name AS label')->where('user_type_id',2)->get();
        /** @var Event $appuntamenti */
        $appuntamenti = Event::with(['patient','doctor','clinic'])
            ->whereMonth('data',$dt)
            ->where('doctor_id',$id)
            ->where('clinic_id',$cl)->get();

        return Inertia::render('Events/Day', [
            "appuntamentiProp" => $appuntamenti,
            "ambulatoriProp" => $ambulatori,
            "mediciProp" => $medici
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function week($inizio,$fine,$id,$cl): \Inertia\Response
    {
        /** @var User $user */
        $user = auth()->user();
        /** @var Clinics $ambulatori */
        $ambulatori = Clinics::all('id AS value','nome AS label');
        /** @var User $medici */
        $medici = User::select('id AS value','name AS label')->where('user_type_id',2)->get();
        /** @var Event $appuntamenti */
        $appuntamenti = Event::with(['patient','doctor','clinic'])->where('data','>=',$inizio)
            ->where('data','<=',$fine)
            ->where('doctor_id',$id)
            ->where('clinic_id',$cl)->get();

        return Inertia::render('Events/Day', [
            "appuntamentiProp" => $appuntamenti,
            "ambulatoriProp" => $ambulatori,
            "mediciProp" => $medici
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function month($id,$ms,$cl): \Inertia\Response
    {
        /** @var User $user */
        $user = auth()->user();
        /** @var Clinics $ambulatori */
        $ambulatori = Clinics::all('id AS value','nome AS label');
        /** @var User $medici */
        $medici = User::select('id AS value','name AS label')->where('user_type_id',2)->get();
//        if(!$user->can("company.list")) {
//            abort(403,"Non disponi dei permessi necessari!");
//        }
        //echo($ms);
        /** @var Event $appuntamenti */
        $appuntamenti = Event::with(['patient','doctor','clinic'])->whereMonth('data',$ms)->where('doctor_id',$id)->where('clinic_id',$cl)->get();;


        return Inertia::render('Events/Month', [
            "appuntamentiProp" => $appuntamenti,
            "ambulatoriProp" => $ambulatori,
            "mediciProp" => $medici
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
            "order" => "nullable|string|in:ascending,descending",
            "filter.tp" => "nullable|int",
            "filter.dt" => "nullable|date",
            "filter.id" => "nullable|int",
            "filter.cl" => "nullable|int",
        ]);;

        $filter = $request->input("filter");

        /** @var User $user */
        $user = auth()->user();

//        if(!$user->can("clinics.list")) {
//            abort(403,"Non disponi dei permessi necessari!");
//        }

        /** @var Event $query */
        $query = Event::query();
        $query->with(['patient','doctor','clinic']);

        if(count($filter)>0){
            $now = Carbon::parse($filter[0]['dt']);
            $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
            $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');

            if($filter[0]['tp'] === 1) {
                $query->where("doctor_id", $filter[0]['id'])
                    ->where("clinic_id", $filter[0]['cl'])
                    ->where("data", $filter[0]['dt']);
            }
            if($filter[0]['tp'] === 2) {
                $query->where("doctor_id", $filter[0]['id'])
                    ->where("clinic_id", $filter[0]['cl'])
                    ->where("data",">=",$weekStartDate)
                    ->where("data", "<=" ,$weekEndDate);
            }
            if($filter[0]['tp'] === 3) {
                $query->where("doctor_id", $filter[0]['id'])
                    ->where("clinic_id", $filter[0]['cl'])
                    ->whereMonth("data", $now->month);
            }
        }
        //echo($query->toSql());


        // RICERCHE CORRELATE
        if(!empty($search = $request->input("search"))) {
            $query->where(function($query2) use ($search) {
                $query2->where("data", "like", '%'.$search.'%')
                    ->orWhere("denominazione", "like", '%'.$search.'%');
            });
        }
        // PAGINAZIONE
        return $query->paginate($request->input("pageSize"));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, event $event)
    {
        //ricordati di mettere il nome del paziente anche nella denominazione
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function save(event $event)
    {
        //ricordati di mettere il nome del paziente anche nella denominazione
    }
}
