<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list(): \Inertia\Response
    {
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("services.list")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        /** @var Service $query */
        $service = Service::all('*');
        return Inertia::render('Services/List', [
            "servicesProp" => $service,
        ]);
    }

    public function serviceList()
    {
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("services.list")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        /** @var Service $service */
        if($user->company_id !== 1) {
            $service = Service::where("company_id",$user->company_id)->get();
        }else{
            $service = Service::all('id','name');
        }
        return $service;
    }

    /**
     * Show the form for creating a new resource.
     * @throws ValidationException
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
        if(!$user->can("services.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        $this->validate($request,[
            "page" => "required|int|min:1",
            "pageSize" => "required|int|min:1",
            "search" => "nullable|string",
            "sort" => "nullable|string",
            "order" => "nullable|string|in:ascending,descending"
        ]);;
            /** @var Service $query */
            $query = Service::query()->with("company:id,ragione_sociale");
            // RICERCHE CORRELATE
            if($user->company_id !== 1) {
                $query->where("company_id",$user->company_id);
            }
            if(!empty($search = $request->input("search"))) {
                $query->where(function($query2) use ($search) {
                    $query2->where("name","like",'%'.$search.'%')
                        ->orWhere("priority", "like", '%'.$search.'%');
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
        Validator::validate([
            "id" => $id
        ], [
            "id" => "required|int|min:0"
        ]);
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("services.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        /** @var Service $service */
        $service = Service::where("id",$id)->first();
        /** @var Company $query */
        $aziende = Company::query()->get();

        return Inertia::render('Services/Edit', [
            "idAzienda" => session()->has("idAzienda") ? session()->get("idAzienda") : null,
            "serviceProp" => $service,
            "aziendeProp" => $aziende
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("services.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        /** @var Company $query */
        if($user->company_id === 1) {
            $aziende = Company::query()->get();
        }else{
            $aziende = Company::where("id",$user->company_id)->first();
        }
        /** @var Service $service */
        $service = Service::where("id",0)->first();
            return Inertia::render('Services/Edit', [
                "serviceProp" => $service,
                "aziendeProp" => $aziende
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save(Request $request)
    {
        Validator::validate($request->all(), [
            "id" => "nullable|integer|exists:services,id",
            "name" => "required|string",
            "priority" => "nullable|integer|min:1"
        ]);
        /** @var User $user */
        $user = auth()->user();
        if(!$user->can("services.edit")) {
            abort(403,"Non disponi dei permessi necessari!");
        }
        /** @var Service $servizio */
        $servizio = Service::where("id",$request->input("id"))->first();
        $oggettoService = [
            'name' => $request->input('name'),
            'company_id' =>  $user->company_id,
            'priority' => $request->input('priority')
        ];
        if(empty($request->input("id"))) {
            $servizio = Service::create($oggettoService);
        } else {
            $servizio->update($oggettoService);
        }
        return response()->json([
            "id" => $servizio->id
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(service $service)
    {
        //
    }
}
