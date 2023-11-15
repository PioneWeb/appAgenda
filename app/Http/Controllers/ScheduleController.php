<?php

namespace App\Http\Controllers;

use App\Models\Clinics;
use App\Models\Company;
use App\Models\Prescription;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use stdClass;

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
//        if(!$user->can("schedule.list")) {
//            abort(403,"Non disponi dei permessi necessari!");
//        }
        return Inertia::render('Schedules/List', [
            "orari" => $orari,
        ]);
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
        ]);;

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

}
