<?php

namespace App\Http\Controllers;

use App\Models\Clinics;
use App\Models\Company;
use App\Models\Event;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
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
//        $user = auth()->user();
//        if(!$user->can("company.list")) {
//            abort(403,"Non disponi dei permessi necessari!");
//        }
        /** @var Clinics $ambulatori */
        $ambulatori = Clinics::all('id AS value','nome AS label');
        /** @var User $medici */
        $medici = User::select('id AS value','name AS label')->where('user_type_id',2)->get();
        /** @var Event $appuntamenti */
        $appuntamenti = Event::all();
        return Inertia::render('Events/List', [
            "ambulatori" => $ambulatori,
            "medici" => $medici,
            "appuntamenti" => $appuntamenti
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function calendar()
    {
        /** @var User $user */
//        $user = auth()->user();
        //        if(!$user->can("company.list")) {
//            abort(403,"Non disponi dei permessi necessari!");
//        }

        /** @var Schedule $orari */
        $orari = Schedule::select('id','giorno','inizio','quantita','minuti')->where('attivo',1)->where('doctor_id',2)->get();
//        echo($orari->toSql());
//        return;
        /** @var Clinics $ambulatori */
        $ambulatori = Clinics::all('id AS value','nome AS label');
        /** @var User $medici */
        $medici = User::select('id AS value','name AS label')->where('user_type_id',2)->get();

        /** @var Event $appuntamenti */
        $appuntamenti = Event::all();

        return Inertia::render('Events/Calendar', [
            "ambulatori" => $ambulatori,
            "medici" => $medici,
            "appuntamenti" => $appuntamenti,
            "orari" => $orari
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
            "sort" => "nullable|string",
            "order" => "nullable|string|in:ascending,descending",
            "filter.tp" => "nullable|int",
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
        $query = Event::select();

        $query->whereDate('start' ,'>=',$filter['start']);
        $query->whereDate('end' ,'<=',$filter['end']);

        if(!empty($filter['medico'])){
            $query->whereIn("doctor_id", $filter['medico']);
        }
        if(!empty($filter['ambulatorio'])) {
            $query->whereIn("clinic_id", $filter['ambulatorio']);
        }

        // PAGINAZIONE
        return response()->json($query->get());

    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        /** @var User $user */
        $user = auth()->user();
        $evento = Event::where("id",$id);
        $evento->update([
            "doctor_id" => $request->input("doctor_id"),
            "patient_id" => $request->input("patient_id"),
            "clinic_id" => $request->input("clinic_id"),
            "title" => $request->input("title"),
            "start" => $request->input("start"),
            "end" => $request->input("end"),
            "stato" => $request->input("stato")
        ]);
        return response()->json(
            $evento->with("doctor","patient","clinic")->first()
        );
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
