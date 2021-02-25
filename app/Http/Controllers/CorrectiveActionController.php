<?php

namespace App\Http\Controllers;

use App\CorrectiveAction;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\DB;
use App\CorrectiveActionFiles;

class CorrectiveActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $correctiveActions = CorrectiveAction::get();
        $users = User::get();

        return view('correctiveActions.correctiveActions',compact('correctiveActions', 'users'));
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
        $error=false;
        $msg="";
    
        $arrayIds=explode(",",$request->participant);
        $users = DB::table('users')
                    ->whereIn('id', $arrayIds)->get();
        
        $participantes="";
        foreach ($users as $user) {
            $participantes=$participantes."".$user->name." ".$user->last_name." ".$user->mother_last_name.",";
        }
        
        
        $correctiveAction=CorrectiveAction::create([
            'issue' => $request->issue,            
            'action' => $request->action,
            'involved' => $participantes,
            'user_id' => $request->user()->id,
            'status' => $request->status,
        ]);

        if ($correctiveAction->save()) {
            $pathFile = 'public/Documents/Accion_Correctiva/'.$correctiveAction->id;

            for ($i=0; $i <$request->tamanoFiles ; $i++) { 
                $nombre="file".$i;
                $archivo = $request->file($nombre);
                $correctiveActionFile=CorrectiveActionFiles::create([
                    'corrective_action_id' => $correctiveAction->id,
                    'file' => $archivo->getClientOriginalName(),
                    'ruta' => 'storage/app/' . $pathFile,
    
                ]);
                $path = $archivo->storeAs(
                    $pathFile, $archivo->getClientOriginalName()
                );
            }
            
            
            $correctiveActionFile->save();
            $msg="Registro guardado con exito";
            
            
        }else{
            $error=true;
        }

        $array=["msg"=>$msg, "error"=>$error];
       
        return response()->json($array);
            
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CorrectiveAction  $correctiveAction
     * @return \Illuminate\Http\Response
     */
    public function show(CorrectiveAction $correctiveAction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CorrectiveAction  $correctiveAction
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = CorrectiveAction::find($id);
        
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
     * @param  \App\CorrectiveAction  $correctiveAction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CorrectiveAction $correctiveAction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CorrectiveAction  $correctiveAction
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $correctiveAction = CorrectiveAction::find($id);
        $correctiveAction->delete();
        return redirect()->route('correctiveActions.index');
    }

    public function showCorrectiveActionFile($correctiveAction)
    {
        
        $files = CorrectiveAction::find($correctiveAction)->correctiveActionFile;
        
        $msg="";
        $error=false;
        

        $array=["msg"=>$msg, "error"=>$error, "correctiveActionfiles"=>$files];

        return response()->json($array);
    }
}
