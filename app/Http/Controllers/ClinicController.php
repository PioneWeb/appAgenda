<?php

namespace App\Http\Controllers;


use App\Models\Clinics;
use App\Models\Company;
use App\Models\DoctorClinics;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Validator;

class ClinicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        /** @var User $user */
        $user = auth()->user();
        /** @var Clinics $query */
        $ambulatori = Clinics::all('*');
//        if(!$user->can("company.list")) {
//            abort(403,"Non disponi dei permessi necessari!");
//        }
        return Inertia::render('Clinics/List', [
            "ambulatori" => $ambulatori,
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function search($id)
    {
        /** @var User $user */
        $user = auth()->user();
//        if(!$user->can("company.list")) {
//            abort(403,"Non disponi dei permessi necessari!");
//        }
        /** @var Clinics $query */
        $ambulatori = Clinics::query('id','nome')->with('DoctorClinics')->whereHas('DoctorClinics', function ($ambulatori) use ($id) {
            $ambulatori->where('doctor_id', $id);
        })->get();

        return Inertia::render('Clinics/List', [
            "ambulatori" => $ambulatori,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("user.list")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        /** @var DoctorClinics $dclinic */
        $dclinic = DoctorClinics::where("clinic_id",$id)->get(['doctor_id']);

        /** @var User $medici */
        $medici = User::where('user_type_id',2)->whereIn('id',$dclinic)->get(['id','name','indirizzo','localita','cap','provincia','telefono']);

        /** @var Clinics $query */
        $query = Clinics::query()->where('id',$id)->with(['team'])->first();
        return Inertia::render('Clinics/Edit', [
            "ambulatorioProp" => $query,
            "medici" => $medici
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

        /** @var Clinics $query */
        $query = Clinics::query();

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /** @var User $user */
        $user = auth()->user();
        /** @var Clinics $ambulatori */
        $ambulatori = Clinics::query()->get();

        /** @var User $medici */
        $medici = User::where('user_type_id',2)->get(['id','name']);

        if(!$user->can("user.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
            return Inertia::render('Clinics/Edit', [
                "ambulatoriProp" => $ambulatori,
                "medici" => $medici
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
    public function save(Request $request)
    {
        Validator::validate($request->all(), [
            "id" => "nullable|integer|exists:clinics,id",
            "nome" => "required|string",
            "indirizzo" => [ "nullable", "string", "max:255" ],
            "localita" => [ "nullable", "string", "max:255" ],
            "cap" => [ "nullable", "string", "max:5" ],
            "provincia" => [ "nullable", "string", "max:255" ],
            "telefono" => [ "nullable", "string", "max:30" ]
        ]);

        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("user.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        if($user->user_type_id===2){
            $doctor_id=$user->id;
        }else{
            $doctor_id=$request->input('doctor_id');
        }
        /** @var Clinics $utente */
        $ambulatorio = Clinics::where("id",$request->input("id"))->first();
        $oggAmbulatorio = [
            'nome' => $request->input('nome'),
            'doctor_id' =>  $doctor_id,
            'indirizzo' =>  $request->input('indirizzo'),
            'localita' =>  $request->input('localita'),
            'cap' =>  $request->input('cap'),
            'provincia' =>  $request->input('provincia'),
            'telefono' =>  $request->input('telefono'),
            'attivo' =>  $request->input('attivo'),
        ];

        if(empty($request->input("id"))) {
            $ambulatorio = Clinics::create($oggAmbulatorio);
        } else {
            $ambulatorio->update($oggAmbulatorio);
        }
        return response()->json([
            "id" => $ambulatorio->id
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, clinic $clinic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(clinic $clinic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function associate($id, $doctor)
    {
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("user.list")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        DoctorClinics::create(['clinic_id' => $id, 'doctor_id' => $doctor]);

        return response()->json([
            "id" => $doctor
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function dissociate($id, $doctor)
    {
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("user.list")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        /** @var Clinics $ambulatorio */
        $ambulatorio = Clinics::where("id",$id)->first();

        /** @var DoctorClinics $doccli */
        $doccli = DoctorClinics::where("clinic_id",$id)->where("doctor_id",$doctor)->first();
        $doccli->delete();

        return response()->json([
            "id" => $doctor
        ]);
    }
}
