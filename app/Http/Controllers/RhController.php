<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Area;
use App\Role;
use App\RhFile;


class RhController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::get();
        $areas = Area::get();
        $usersEliminados = User::onlyTrashed()->get();
        $users = DB::table('users')
            ->join('areas', 'users.area_id', '=', 'areas.id')
            ->select('users.*', 'areas.name as area_name')
            ->whereNull('users.deleted_at')
            ->get();
        
      
        return view('rh.rh',compact('users','roles', 'areas', 'usersEliminados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::get();
        $areas = Area::get();
        $roleUser = User::find($id)->roles;
        $msg="";
        $error=false;
        $array=["msg"=>$msg, "error"=>$error, "user"=>$user, "roles"=>$roles, "areas"=>$areas, "roleUser"=>$roleUser];
        return response()->json($array);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function files($id)
    {
        $files = RhFile::find($id)->sgcFile;
        
        $msg="";
        $error=false;
        

        $array=["msg"=>$msg, "error"=>$error, "files"=>$files];

        return response()->json($array);
    }
}
