<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


use Datatables;

class UsersController extends Controller {
    public function index() {
        if (request()->ajax()) {
            return datatables()->of(User::select('*'))
                ->addColumn('action', 'user-action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $userId = $request->id;

        $req = $request->age;
        $j = filter_var($req, FILTER_SANITIZE_NUMBER_INT);

        $user   =   User::updateOrCreate(
            [
                'id' => $userId
            ],
            [
                'name' => strtoupper($request->name),
                'age' => $j,
                'city' => strtoupper($request->city),
            ]
        );

        return Response()->json($user);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {
        $where = array('id' => $request->id);
        $user  = User::where($where)->first();
        return Response()->json($user);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        $user = User::where('id', $request->id)->delete();

        return Response()->json($user);
    }
}
