<?php

namespace App\Http\Controllers;

use App\Models\Clinics;
use App\Models\Company;
use App\Models\DoctorClinics;
use App\Models\DoctorUsers;
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
        $ambulatori = Clinics::all('id','nome');
        /** @var User $medici */
        $medici = User::select('id','name')->where('user_type_id',2)->with('clinics:clinics.id,clinics.nome')->get();
        /** @var User $pazienti */
        $pazienti = User::select('id','name')->where('user_type_id',3)->get();

        /** @var Event $appuntamenti */
        $appuntamenti = Event::all();
        return Inertia::render('Events/List', [
            "ambulatori" => $ambulatori,
            "medici" => $medici,
            "pazienti" => $pazienti,
            "appuntamenti" => $appuntamenti
        ]);
    }

    public function appuntamenti()
    {
        /** @var User $user */
        $user = auth()->user();
        //        if(!$user->can("company.list")) {
//            abort(403,"Non disponi dei permessi necessari!");
//        }

        if($user->user_type_id === 1){
            /** @var Clinics $ambulatori */
            $ambulatori = Clinics::all('id','nome');
            /** @var User $medici */
            $medici = User::select('id','name')->where('user_type_id',2)->with(['clinics:clinics.id,clinics.nome'])->get();
            /** @var Event $appuntamenti */
            $appuntamenti = Event::all();
        }else {
            if($user->user_type_id === 3){
                /** @var DoctorUsers $doc */
                $doc = DoctorUsers::where('user_id', $user->id)->first('doctor_id');
                /** @var DoctorClinics $amb */
                $amb = DoctorClinics::where('doctor_id', $doc->doctor_id)->get('clinic_id');
                /** @var Clinics $ambulatori */
                $ambulatori = Clinics::select(['id', 'nome'])->where('attivo', 1)->whereIn('id', $amb)->get();
                /** @var User $medici */
                $medici = User::select('id','name')->where('id', $doc->doctor_id)->where('user_type_id',2)->get();
                /** @var Event $appuntamenti */
                $appuntamenti = Event::query()->where('patient_id', $user->id)->get();
            }else {
                if($user->user_type_id === 2){
                    /** @var DoctorClinics $amb */
                    $amb = DoctorClinics::where('doctor_id', $user->id)->get('clinic_id');
                    /** @var Clinics $ambulatori */
                    $ambulatori = Clinics::select(['id', 'nome'])->where('attivo', 1)->whereIn('id', $amb)->get();
                    /** @var User $medici */
                    $medici = User::select('id', 'name')->where('id', $user->id)->where('user_type_id', 2)->get();
                    /** @var Event $appuntamenti */
                    $appuntamenti = Event::query()->where('doctor_id', $user->id)->get();
                }else{
                    /** @var DoctorUsers $doc */
                    $doc = DoctorUsers::where('user_id', $user->id)->first('doctor_id');
                    /** @var DoctorClinics $amb */
                    $amb = DoctorClinics::where('doctor_id', $doc->doctor_id)->get('clinic_id');
                    $amb = $amb->pluck('clinic_id');
                    /** @var Clinics $ambulatori */
                    $ambulatori = Clinics::select(['id', 'nome'])->where('attivo', 1)->whereIn('id', $amb)->get();
                    /** @var User $medici */
                    $medici = User::select('id', 'name')->where('user_type_id', 2)->get();
                    /** @var Event $appuntamenti */
                    $appuntamenti = Event::all();
                }
            }
        }
        return Inertia::render('Events/Appuntamenti', [
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

        /** @var Clinics $ambulatori */
        $ambulatori = Clinics::all('id AS value','nome AS label');
        /** @var User $medici */
        $medici = User::select('id AS value','name AS label')->where('user_type_id',2)->get();;
        /** @var User $pazienti */
        $pazienti = User::select('id AS value','name AS label')->where('user_type_id',3)->get();

        /** @var Event $appuntamenti */
        $appuntamenti = Event::all();

        return Inertia::render('Events/Calendar', [
            "ambulatori" => $ambulatori,
            "medici" => $medici,
            "pazienti" => $pazienti,
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
    public function edit($id)
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
            "filter.medico" => "nullable|int",
            "filter.ambulatorio" => "nullable|int ",
            "filter.search" => "nullable|string",
        ]);

        $filter = $request->input("filter");

        /** @var User $user */
        $user = auth()->user();

//        if(!$user->can("clinics.list")) {
//            abort(403,"Non disponi dei permessi necessari!");
//        }

        /** @var Event $query */
        $query = Event::with("doctor","patient","clinic");

        $query->whereDate('start' ,'=',$filter['start']);
        //$query->whereDate('end' ,'<=',$filter['end']);

        if(!empty($filter['medico'])){
            $query->where("doctor_id", $filter['medico']);
        }
        if(!empty($filter['ambulatorio'])) {
            $query->where("clinic_id", $filter['ambulatorio']);
        }
        if($user->user_type_id === 3){
            $query->where("patient_id", $user->id);
        }
        // PAGINAZIONE
        return response()->json($query->orderBy('start')->get());

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
    public function delete($id)
    {
        /** @var User $user */
        $user = auth()->user();
//        if(!$user->can("agenti.list")) {
//            abort(403,"Non disponi dei permessi necessari!");
//        }
            Event::where("id", $id)->delete();
            return response()->json([
                "id" => $id
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function save(Request $request)
    {
        //ricordati di mettere il nome del paziente anche nella denominazione
        $this->validate($request,[
            "clinic_id" => "nullable|int|exists:clinics,id",
            "doctor:id" => "nullable|int|exists:users,id",
            "patient_id" => "nullable|int|exists:users,id",
            "title" => "nullable|string",
            "start" => "nullable|date",
            "end" => "nullable|date",
        ]);

        /** @var User $user */
        $user = auth()->user();
//        if(!$user->can("user.edit")) {
//            abort(403,"Non disponi dei permessi necessari!");
//        }
        /** @var User $paziente */
        $paziente = User::select('name')->where('id',$request->input("patient_id"))->first();
        if($request->input("descrizione") == null){
            $descrizione = $paziente->name;
        }else{
            $descrizione = $request->input("descrizione");
        }
       $oggEvento = [
             "clinic_id" => $request->input("clinic_id"),
             "doctor_id" => $request->input("doctor_id"),
             "patient_id" => $request->input("patient_id"),
             "title" => $descrizione,
             "start" => $request->input("start"),
             "end" => $request->input("end"),
             "stato" => $request->input("stato")
        ];

        if(empty($request->input("id"))) {
            $evento = Event::create($oggEvento);
        } else {
            /** @var Event $evento */
            $evento = Event::where("id",$request->input('id')->first())->update($oggEvento);
        }
        return response()->json([
            "id" => $evento->id
        ]);
    }
}
