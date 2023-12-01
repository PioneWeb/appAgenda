<?php

namespace App\Http\Controllers;

use App\Models\Clinics;
use App\Models\Company;
use App\Models\Prescription;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use stdClass;
use Validator;

class ScheduleController extends Controller
{
//edit
//create
//paginate
//save

    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        /** @var User $user */
        $user = auth()->user();
        /** @var Schedule $orari */
        $orari = Schedule::with(['doctor','patient','clinic']);
        return Inertia::render('Schedules/List', [
            "orari" => $orari,
        ]);
    }


    public function orariList(Request $request)
    {
        $this->validate($request,[
            "doctor_id" => "required|int|exists:users,id",
            "clinic_id" => "required|int|exists:clinics,id",
            "date" => "required|date"
        ]);

        $gg = Carbon::parse($request->input("date"))->dayOfWeekIso;
        /** @var User $user */
        $user = auth()->user();
        if($user->can("schedule.orariList")) {}
        /** @var Schedule $orari */
        $orari = Schedule::all()->where('doctor_id',$request->input("doctor_id"))
            ->where('clinic_id',$request->input("clinic_id"))
            ->where('giorno',$gg)
            ->where('attivo',1);

        return $orari;

    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        /** @var User $user */
        $user = auth()->user();
        if($user->can("user.list")) {
            /** @var Schedule $query */
            $query = Schedule::query()->where('id',$id)->with(["doctor","patient","clinic"])->first();
            $doctors = User::where('user_type_id',2)->get();
            $clinics = Clinics::all();

            return Inertia::render('Schedules/Edit', [
                "orariProp" => $query,
                "mediciProp" => $doctors,
                "ambulatoriProp" => $clinics
            ]);
        }
        abort(403,"Non disponi dei permessi necessari!");
    }


    // RENDER CREAZIONE
    public function create()
    {
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("user.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        $doctors = User::where('user_type_id',2)->get();
        $clinics = Clinics::all();
            return Inertia::render('Schedules/Edit', [
                "orariProp" => new stdClass(),
                "mediciProp" => $doctors,
                "ambulatoriProp" => $clinics
            ]);
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
        ]);

        /** @var User $user */
        $user = auth()->user();

//        if(!$user->can("clinics.list")) {
//            abort(403,"Non disponi dei permessi necessari!");
//        }

        /** @var Schedule $query */
        $query = Schedule::with(['doctor','patient','clinic']);

        // RICERCHE CORRELATE
//        if(!empty($search = $request->input("search"))) {
//            $query->where(function($query2) use ($search) {
//                $query2->where("email","like",'%'.$search.'%')
//                    ->orWhere("name", "like", '%'.$search.'%');
//            });
//        }

        // PAGINAZIONE
        return $query->paginate($request->input("pageSize"));

    }

    /**
     * Display the specified resource.
     */
    public function save(Request $request): \Illuminate\Http\JsonResponse
    {
        Validator::validate($request->all(), [
            "id" => "nullable|integer|exists:prescriptions,id",
            "doctor_id" => "nullable|integer|exists:users,id",
            "clinic_id" => "nullable|integer|exists:clinics,id",
            "tipo" => [ "nullable", "integer", "max:255" ],
            "quantita" => [ "nullable", "integer", "max:255" ],
            "minuti" => [ "nullable", "integer", "max:255" ],
            "giorno" => [ "nullable", "integer"],
            "inizio" => [ "nullable", "string", "max:5" ],
            "attivo" => [ "nullable", "boolean" ]
        ]);

        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("user.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        /** @var Schedule $ricetta */
        $orario = Schedule::where("id",$request->input("id"))->first();
        $oggOrario = [
            'nome' => $request->input('nome'),
            'doctor_id' => $request->input('doctor_id'),
            'clinic_id' => $request->input('clinic_id'),
            'tipo' => $request->input('tipo'),
            'quantita' => $request->input('quantita'),
            'minuti' => $request->input('minuti'),
            'giorno' => $request->input('giorno'),
            'inizio' => $request->input('inizio'),
            'attivo' => $request->input('attivo') === null ? 1 : $request->input('attivo'),
        ];

        if(empty($request->input("id"))) {
            $orario = Schedule::create($oggOrario);
        } else {
            $orario->update($oggOrario);
        }
        return response()->json([
            "id" => $orario->id
        ]);

    }


    /**
     * Display the specified resource.
     */
    public function sino(Request $request)
    {
        Validator::validate($request->all(), [
            "idOrario" => "nullable|integer|exists:prescriptions,id",
            "attivo" => "required|boolean"
        ]);

        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("user.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        /** @var Schedule $orario */
        $orario = Schedule::where("id",$request->input("id"))->first();

        $orario->update([
            'attivo' => !$orario->attivo
        ]);
        return response()->json([
            "id" => $orario->id,
            "attivo" => $orario->attivo
        ]);

    }
}
