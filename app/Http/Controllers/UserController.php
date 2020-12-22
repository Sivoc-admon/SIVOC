<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   
    protected $users;

    public function index()
    {
        //
        $users = User::get();
        
        return view('users.users')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('users.create');
        
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
        
        /*$request->validate([
            'nombre' => 'required',
            'apellido_paterno' => 'required',
        ]);*/
        $user = new User;
       
        $user->name = $request->input('inputName');
        $user->last_name = $request->input('inputLastName');
        $user->mother_last_name = $request->input('inputMotherLastName');
        $user->mail = $request->input('inputEmail');
        $user->password = Hash::make($request->input('inputPassword'));
        $user->gender = $request->input('sltGenero');
        $user->marital_status = $request->input('inputEstadoCivil');
        $user->nss = $request->input('inputNSS');
        
        $user->save();

        return redirect()->route('users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->users->find($id);

        return view('users.profile', ['users' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::find($id);
        return view('users.edit')->with('users',$user);
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
        $user = User::find($id);

        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->mother_last_name = $request->input('mother_last_name');
        $user->birthday = $request->input('birthday');
        $user->age = $request->input('age');
        $user->gender = $request->input('gender');
        $user->marital_status = $request->input('marital_status');
        $user->nss = $request->input('nss');
        
        $user->save();
        return redirect()->route('users.index');
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
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users');
    }
}
