<?php

namespace App\Http\Controllers;
use App\Models\Clinics;
use App\Models\Company;
use App\Models\Team;
use App\Models\User;
use App\Models\UserType;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Validator;

class UsersController extends Controller
{
    public function list(): \Inertia\Response
    {
        /** @var User $user */
        $user = auth()->user();
        /** @var User $query */
        $clienti = User::with(["medico"])->where('current_team_id',$user->current_team_id);
        if($user->can("user.list")) {
        return Inertia::render('Users/List', [
            "utenti" => $clienti,
        ]);
        }
        abort(403,"Non disponi dei permessi necessari!");
    }

    public function usersList()
    {
        /** @var User $user */
        $user = auth()->user();
        if($user->can("user.list")) {
            /** @var User $utenti */
            $utenti = User::all('id','name')
                ->where('current_team_id',$user->current_team_id);
            return $utenti;
        }
    }

    public function doctorsList()
    {
        /** @var User $user */
        $user = auth()->user();
        if($user->can("user.list")) {
            /** @var User $medici */
            $medici = User::all('id','name')
                ->where('current_team_id',$user->current_team_id)
                ->where('user_type_id',2);
            return $medici;
        }
    }

    public function patientsList()
    {
        /** @var User $user */
        $user = auth()->user();
        if($user->can("user.list")) {
            /** @var User $pazienti */
            $pazienti = User::query('id','name')
                ->where('current_team_id',$user->current_team_id)
                ->where('user_type_id',3)->get();
            return $pazienti;
        }
    }

    public function ticketUsersList()
    {
        /** @var User $user */
        $user = auth()->user();
        if($user->can("user.list")) {
            /** @var User $utenti */
            $utenti = User::select('id','name')
                ->where('current_team_id',$user->current_team_id)
                ->where("company_id","1")->get();
            return $utenti;
        }
    }

    // RENDER CREAZIONE
    public function create()
    {
        /** @var User $user */
        $user = auth()->user();
        /** @var Company[] $aziende */
        $aziende = Company::query()->where('current_team_id',$user->current_team_id)->get();
        if($user->can("user.edit")) {
            return Inertia::render('Users/Edit', [
                "aziendeProp" => $aziende
            ]);
        }
        abort(403,"Non disponi dei permessi necessari!");
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

        if(!$user->can("user.list")) {
            abort(403,"Non disponi dei permessi necessari!");
        }

        /** @var User $query */
        $query = User::with(['user_type','medico','medico.patients','teams'])
                 ->where('current_team_id',$user->current_team_id);

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

    public function save(Request $request) {
        Validator::validate($request->all(), [
            "id" => "nullable|integer|exists:users,id",
            "name" => "required|string",
            "localita" => [ "nullable", "string", "max:255" ],
            "cap" => [ "nullable", "string", "max:5" ],
            "provincia" => [ "nullable", "string", "max:2" ],
            "telefono" => [ "nullable", "string", "max:40", "regex:/^\d{8,15}$/" ],
        ]);
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("user.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        /** @var User $utente */
        $utente = User::where("id",$request->input("id"))->first();
        $oggettoUser = [
            'name' => $request->input('name'),
            'email' =>  $request->input('email'),
            'localita' =>  $request->input('localita'),
            'cap' =>  $request->input('cap'),
            'provincia' =>  $request->input('provincia'),
            'telefono' =>  $request->input('telefono'),
            'user_type_id' =>  $request->input('user_type_id'),
        ];

        if(empty($request->input("id"))) {
            $utente = User::create($oggettoUser);
        } else {
            $utente->update($oggettoUser);
        }
        return response()->json([
            "id" => $utente->id
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function verify(Request $request)
    {
        Validator::validate($request->all(), [
            "id" => "nullable|integer|exists:users,id",
        ]);
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("user.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        /** @var User $utente */
        $utente = User::where("id",$request->input("id"))->first();
        $utente->update(['email_verified_at' => Carbon::now()]);
        return response()->json([
            "id" => $utente->id
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) {
        /** @var User $user */
        $user = auth()->user();
        if($user->can("user.list")) {
            /** @var User $query */
            $query = User::query()->where('id',$id)
                ->with(['user_type','medico.patients','medico','patients','teams','clinics'])
                ->where('current_team_id',$user->current_team_id)
                ->first();
            /** @var Company $query */
            $aziende = Company::query()->get();
            /** @var Team $query */
            $team = Team::query()->get();
            /** @var UserType $tipi */
            $tipi = UserType::query()->get();

            /** @var Clinics $ambulatori */
            $ambulatori = Clinics::where('team_id',$user->current_team_id)->get();

            return Inertia::render('Users/Edit', [
                "utenteProp" => $query,
                "aziendeProp" => $aziende,
                "teamProp" => $team,
                "tipiProp" => $tipi,
                "ambulatoriProp" => $ambulatori
            ]);
        }
        abort(403,"Non disponi dei permessi necessari!");
    }

}

