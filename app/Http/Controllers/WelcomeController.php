<?php

namespace App\Http\Controllers;

use App\Welcome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\WelcomeFile;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $buttons = DB::table('welcome')
            ->join('welcome_files', 'welcome_files.welcome_id', '=', 'welcome.id')
            ->select('welcome.id', 'welcome.name as button', 'welcome.color', 'welcome_files.name as nameFile', 'welcome_files.ruta')
            ->whereNull('welcome.deleted_at')
            ->get();

        return view('welcome',compact('buttons'));
    }

    public function buttons()
    {

        $buttons = DB::table('welcome')
            ->join('welcome_files', 'welcome_files.welcome_id', '=', 'welcome.id')
            ->select('welcome.id', 'welcome.name as button', 'welcome.color', 'welcome_files.name as nameFile', 'welcome_files.ruta')
            ->whereNull('welcome.deleted_at')
            ->get();

        return view('buttons.buttons',compact('buttons'));
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
                 
        $button=Welcome::create([
            'name' => $request->name, 
            'color' => $request->color,
            
        ]);
        $error=false;
        $msg="";
        
        if ($button->save()) {
            $pathFile = 'public/Documents/welcome/'.$button->id;

            for ($i=0; $i <$request->tamanoFiles ; $i++) { 
                $nombre="file".$i;
                $archivo = $request->file($nombre);
                $welcomeFile=WelcomeFile::create([
                    'welcome_id' => $button->id,
                    'name' => $archivo->getClientOriginalName(),
                    'ruta' => 'storage/Documents/welcome/',
    
                ]);
                $path = $archivo->storeAs(
                    $pathFile, $archivo->getClientOriginalName()
                );
            }
            
            
            $welcomeFile->save();
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
     * @param  \App\Welcome  $welcome
     * @return \Illuminate\Http\Response
     */
    public function show(Welcome $welcome)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Welcome  $welcome
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $welcome = Welcome::find($id);
        
        
        $msg="";
        $error=false;
        $array=["msg"=>$msg, "error"=>$error, "welcome"=>$welcome];
        return response()->json($array);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Welcome  $welcome
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $button = Welcome::find($id);
        
        $ubuttonser->update([
            'name' => $request->inputEditButton,
            'color' => $request->sltEditColorButton,
            
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Welcome  $welcome
     * @return \Illuminate\Http\Response
     */
    public function destroy(Welcome $welcome)
    {
        //
    }
}
