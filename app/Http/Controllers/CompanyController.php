<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Validator;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        /** @var User $user */
        $user = auth()->user();
        /** @var Company $query */
        $aziende = Company::all('*');
        //if($user->can("company.list")) {
            return Inertia::render('Companies/List', [
                "idAzienda" => session()->has("idAzienda") ? session()->get("idAzienda") : null,
                "aziende" => $aziende,
            ]);
        //}
        abort(403,"Non disponi dei permessi necessari!");
    }

    public function companyList()
    {
        /** @var User $user */
        $user = auth()->user();
        if($user->can("company.list")) {
            /** @var Company $aziende */
            $aziende = Company::all('id','ragione_sociale');
            return $aziende;
        }
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
        if($user->can("company.list")) {
            /** @var Company $query */
            $query = Company::query();

            // RICERCHE CORRELATE
            if(!empty($search = $request->input("search"))) {
                $query->where(function($query2) use ($search) {
                    $query2->where("email","like",'%'.$search.'%')
                        ->orWhere("piva", "like", '%'.$search.'%')
                        ->orWhere("iban", "like", '%'.$search.'%')
                        ->orWhere("codice_destinatario", "like", '%'.$search.'%')
                        ->orWhere("ragione_sociale", "like", '%'.$search.'%');
                });
            }
            // PAGINAZIONE
            return $query->paginate($request->input("pageSize"));
        }
        abort(403,"Non disponi dei permessi necessari!");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function save(Request $request) {
        Validator::validate($request->all(), [
            "id" => "nullable|integer|exists:companies,id",
            "attivo" => "required|boolean",
            "cellulare" => [
                "nullable",
                "string",
                "max:40",
                "regex:^(-?|\+)?\d{0,8}\s*\d{8,15}$^"
            ],
        ]);
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("company.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        /** @var Company $company */
        $company = Company::where("id",$request->input("id"))->first();
        $oggettoCompany = [
            "attivo" => $request->input('attivo'),
            'email' =>  $request->input('email'),
            'ragione_sociale' => $request->input('ragione_sociale'),
            'localita' =>  $request->input('localita'),
            'cap' =>  $request->input('cap'),
            'provincia' =>  $request->input('provincia'),
            'piva' =>  $request->input('piva'),
            'iban' =>  $request->input('iban'),
            'telefono' =>  $request->input('telefono'),
            'cellulare' =>  $request->input('cellulare'),
            'codice_destinatario' =>  $request->input('codice_destinatario'),
            'pec' =>  $request->input('pec'),
            'privato' =>  $request->input('privato'),
            'pubblico' =>  $request->input('pubblico'),
        ];

        if(empty($request->input("id"))) {
            $company = Company::create($oggettoCompany);
        } else {
            $company->update($oggettoCompany);
        }
        return response()->json([
            "id" => $company->id
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
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) {
        /** @var User $user */
        $user = auth()->user();
        if($user->can("company.list")) {
            /** @var Company $query */
            $query = Company::query()->where('id',$id)->with("services")->first();
            return Inertia::render('Companies/Edit', [
                "idAzienda" => session()->has("idAzienda") ? session()->get("idAzienda") : null,
                "aziendaProp" => $query,
            ]);
        }
        abort(403,"Non disponi dei permessi necessari!");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }
}
