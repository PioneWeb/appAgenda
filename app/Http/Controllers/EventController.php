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
            "sort" => "nullable|string",
            "order" => "nullable|string|in:ascending,descending",
            "filter.tp" => "nullable|int",
            "filter.dt" => "nullable|date",
            "filter.medico" => "nullable|array",
            "filter.ambulatorio" => "nullable|array",
            "filter.search" => "nullable|string",
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
        $lst = $filter['data'];
        $filter['data'] === null ? $filter['data'] = Carbon::now()->format('Y-m-d') : $filter['data'];
        $now = Carbon::parse(Carbon::parse($filter['data'])->format('Y-m-d'));

        $weekStartDate = $now->startOfWeek()->format('Y-m-d');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d');

        if(!empty($filter['medico'])){
            $query->whereIn("doctor_id", $filter['medico']);
        }
        if(!empty($filter['ambulatorio'])) {
            $query->whereIn("clinic_id", $filter['ambulatorio']);
        }

        if($filter['tp'] === 0) {
            if($lst !== null){
            $query->whereDate("start", $filter['data']);
            }
        }
        if($filter['tp'] === 1) {
            $query->whereDate("start", $filter['data']);
        }
        if($filter['tp'] === 2) {
            $query->whereDate("start",">=",$weekStartDate)
                ->whereDate("start", "<=" ,$weekEndDate);
        }
        if($filter['tp'] === 3) {
            $query->whereMonth("start", $now->month)->whereYear("start", $now->year);
        }

        // RICERCHE CORRELATE
        if(!empty($search = $filter['search'])) {
            $query->where(function($query2) use ($search) {
                $query2->whereDate("start", "like", '%'.$search.'%')
                    ->orWhere("denominazione", "like", '%'.$search.'%');
            });
        }
//        logger('request start ', [Carbon::parse($filter['start'])]);
//        logger('start ', [$now]);
//        logger('inizio',[$weekStartDate]);
//        logger('fine',[$weekEndDate]);
//        logger($query->toSql());

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
