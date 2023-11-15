<?php

namespace App\Http\Controllers;

use App\Models\Clinics;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use stdClass;
use Validator;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        /** @var User $user */
        $user = auth()->user();
        /** @var Prescription $query */
        $ricette = Prescription::with(['doctor','patient']);
//        if(!$user->can("company.list")) {
//            abort(403,"Non disponi dei permessi necessari!");
//        }
        return Inertia::render('Prescriptions/List', [
            "ricette" => $ricette,
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
        ]);;

        /** @var User $user */
        $user = auth()->user();

//        if(!$user->can("clinics.list")) {
//            abort(403,"Non disponi dei permessi necessari!");
//        }

        /** @var Prescription $query */
        $query = Prescription::with(['doctor','patient']);

        // RICERCHE CORRELATE
        if(!empty($search = $request->input("search"))) {
            $query->where(function($query2) use ($search) {
                $query2->where("email","like",'%'.$search.'%')
                    ->orWhere("name", "like", '%'.$search.'%');
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
        /** @var User $user */
        $user = auth()->user();
        if($user->can("user.list")) {
            /** @var Prescription $query */
            $query = Prescription::query()->where('id',$id)->with(["doctor","patient"])->first();
            $doctors = User::where('user_type_id',2)->get();
            $patients = User::where('user_type_id',3)->get();

            return Inertia::render('Prescriptions/Edit', [
                "ricettaProp" => $query,
                "mediciProp" => $doctors,
                "pazientiProp" => $patients
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
        $patients = User::where('user_type_id',3)->get();

        return Inertia::render('Prescriptions/Edit', [
            "ricettaProp" => new stdClass(),
            "mediciProp" => $doctors,
            "pazientiProp" => $patients
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function save(Request $request)
    {
        Validator::validate($request->all(), [
            "id" => "nullable|integer|exists:prescriptions,id",
            "doctor_id" => "nullable|integer|exists:users,id",
            "clinic_id" => "nullable|integer|exists:clinics,id",
            "patient_id" => "nullable|integer|exists:users,id",
            "farmaci" => [ "nullable", "string", "max:255" ],
            "motivo" => [ "nullable", "string", "max:255" ],
            "attiva" => [ "nullable", "boolean", "max:5" ],
            "tipo" => [ "nullable", "integer", "max:255" ]
        ]);

        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("user.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        /** @var Prescription $ricetta */
        $ricetta = Prescription::where("id",$request->input("id"))->first();
        $oggRicetta = [
            'nome' => $request->input('nome'),
            'doctor_id' => $request->input('doctor_id'),
            'clinic_id' => $request->input('clinic_id'),
            'patient_id' => $request->input('patient_id'),
            'farmaci' => $request->input('farmaci'),
            'motivo' => $request->input('motivo'),
            'attiva' => $request->input('attiva'),
            'tipo' => $request->input('tipo'),
        ];

        if(empty($request->input("id"))) {
            $ricetta = Prescription::create($oggRicetta);
        } else {
            $ricetta->update($oggRicetta);
        }
        return response()->json([
            "id" => $ricetta->id
        ]);

    }
}
