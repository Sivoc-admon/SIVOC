<?php

namespace App\Http\Controllers;

use App\Minute;
use Illuminate\Http\Request;
use App\Agreement;
use App\User;
use App\AgreementFile;
use Illuminate\Support\Facades\DB;

class MinuteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $minutes = Minute::get();
       $users = User::get();

       return view('minutes.minutes',compact('minutes', 'users'));
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
        $arrayIds=explode(",",$request->internalParticipant);
        $users = DB::table('users')
                    ->whereIn('id', $arrayIds)->get();
        
        $participantes="";
        foreach ($users as $user) {
            $participantes=$participantes."".$user->name." ".$user->last_name." ".$user->mother_last_name.",";
        }
         
        $minute=Minute::create([
            'description' => $request->minuteDescription, 
            'participant' => $participantes,
            'external_participant' => $request->externalParticipant,
            'type' => $request->type,
            'status' => $request->status,
        ]);
        $error=false;
        $msg="";
        
        if ($minute->save()) {
            $pathFile = 'public/Documents/Minutas/'.$minute->id;

            for ($i=0; $i <$request->tamanoFiles ; $i++) { 
                $nombre="file".$i;
                $archivo = $request->file($nombre);
                $agreementFile=AgreementFile::create([
                    'minute_id' => $minute->id,
                    'file' => $archivo->getClientOriginalName(),
                    'ruta' => 'storage/app/' . $pathFile,
    
                ]);
                $path = $archivo->storeAs(
                    $pathFile, $archivo->getClientOriginalName()
                );
            }
            
            
            $agreementFile->save();
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
     * @param  \App\Minute  $minute
     * @return \Illuminate\Http\Response
     */
    public function show(Minute $minute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Minute  $minute
     * @return \Illuminate\Http\Response
     */
    public function edit(Minute $minute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Minute  $minute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Minute $minute)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Minute  $minute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Minute $minute)
    {
        //
    }
    
    public function storeAgreement(Request $request)
    {
        $agrements=Agreement::create([
            'minute_id' => $request->input('inputIdMinute'),
            'description' => $request->input('inputDescriptionAgreement'),            
            
        ]);
        $error=false;
        $msg="";
        if ($agrements->save()) {
            $msg="Registro guardado con exito";
        }else{
            $error=true;
        }

        $array=["msg"=>$msg, "error"=>$error];
        
        return response()->json($array);
    }

    public function showAgreement($minute)
    {
        //$agrements = Agreements::get();
        
        $agreements = Minute::find($minute)->Agreements;

        //dd($agrements);

        $msg="";
        $error=false;
        

        $array=["msg"=>$msg, "error"=>$error, "agreements"=>$agreements];

        return response()->json($array);
        //return view('minutes.register_agreement',compact('agreements'));
    }

    public function showMinuteFile($minute)
    {
        
        $files = Minute::find($minute)->agreementFiles;
        
        $msg="";
        $error=false;
        

        $array=["msg"=>$msg, "error"=>$error, "minutefiles"=>$files];

        return response()->json($array);
    }
}
