<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Area;

use Illuminate\Support\Facades\DB;
use Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
   
    protected $users;

    public function index()
    {
        
        //$users = User::get();
        $roles = Role::get();
        $areas = Area::get();
        $users = DB::table('users')
            ->join('areas', 'users.area_id', '=', 'areas.id')
            ->select('users.*', 'areas.name as area_name')
            ->get();
        
      
        return view('users.users',compact('users','roles', 'areas'));
        
        
        //return view('users.users')->with('users', $users);
  
        //return view('users.index')->with('users', $users);
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
        $request->validate([
            'inputName' => 'required',
            'inputLastName' => 'required',
            'inputMotherLastName' => 'required',
            'inputEmail' => 'required',
            'inputPassword' => 'required',
            
        ]);
        $msg="";
        $error=false;
        $user = new User;
        $count = User::where('email', $request->input('inputEmail'))->count();
        
        if ($count>0) {
            $msg="El correo ya existe, intente con otro.";
            $error=true;
            
        }else{
            $user=User::create([
                'name' => $request->input('inputName'),            
                'last_name' => $request->input('inputLastName'),
                'mother_last_name' => $request->input('inputMotherLastName'),
                'area_id' => $request->input('sltArea'),
                'email' => $request->input('inputEmail'),
                'password' => Hash::make($request->input('inputPassword')),
                /*'gender' => $request->input('sltGenero'),
                'marital_status' => $request->input('inputEstadoCivil'),
                'nss' => $request->input('inputNSS'),*/
            ]);

            
            if ($user->save()) {
                $user->roles()->attach(Role::where('id', $request->input('inputRole'))->first());
            }else{
                $error=true;
            }

            
            
            
            /*$user->name = $request->input('inputName');
            $user->last_name = $request->input('inputLastName');
            $user->mother_last_name = $request->input('inputMotherLastName');
            $user->mail = $request->input('inputEmail');
            $user->password = Hash::make($request->input('inputPassword'));
            $user->gender = $request->input('sltGenero');
            $user->marital_status = $request->input('inputEstadoCivil');
            $user->nss = $request->input('inputNSS');
            
            $user->save();*/
        }

        $array=["msg"=>$msg, "error"=>$error];
        if ($error===true) {
            //return Response::json($array);
            return response()->json($array);
        }else{
            return response()->json($array);
            //return redirect()->route('users.users');
        }
  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('products.show',compact('product'));
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
        //dd(Crypt::decrypt($user->password));
        //$password = Crypt::decrypt($user->password);
        $msg="";
        $error=false;
        $array=["msg"=>$msg, "error"=>$error, "user"=>$user];
        return response()->json($array);
        
        //return view('users.edit', compact('user','password', 'areas'));
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
        return redirect()->route('users.index');
    }
}
