<?php

namespace App\Http\Controllers;

use App\Sgc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SgcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sgcs = DB::table('sgc')
            ->join('users', 'users.id', '=', 'sgc.responsable')
            ->join('sgc_files', 'sgc_files.sgc_id', '=', 'sgc.id')
            ->select('users.name as user_name', 'users.last_name', 'users.mother_last_name', 'users.id', 'sgc.*', 'sgc_files.*')
            ->whereNull('sgc.deleted_at')
            ->get();
        

        return view('sgc.sgc',compact('sgcs'));
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
        $msg="";
        $error=false;

        $internalAudit=InternalAudit::create([
            'area_id' => $request->area,            
            'user_id' => $request->evaluador,
            'date_register' => $request->fecha,
            
        ]);

        if ($internalAudit->save()) {
            $pathFile = 'public/Documents/Auditoria_interna/'.$internalAudit->id;

            for ($i=0; $i <$request->tamanoFiles ; $i++) { 
                $nombre="file".$i;
                $archivo = $request->file($nombre);
                $internalAuditFile=InternalAuditFile::create([
                    'internal_audits_id' => $internalAudit->id,
                    'name' => $archivo->getClientOriginalName(),
                    'ruta' => 'storage/app/' . $pathFile,
    
                ]);
                $path = $archivo->storeAs(
                    $pathFile, $archivo->getClientOriginalName()
                );
            }
            
            if ($internalAuditFile->save()) {
                $msg="Registro guardado con exito";
            }else {
                $msg="Error al guardar el archivo";
                $error=true;
            }
            
            
        }else{
            $msg="Error al guardar el registro";
            $error=true;
        }

        $array=["msg"=>$msg, "error"=>$error];
       
        return response()->json($array);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sgc  $sgc
     * @return \Illuminate\Http\Response
     */
    public function show(Sgc $sgc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sgc  $sgc
     * @return \Illuminate\Http\Response
     */
    public function edit(Sgc $sgc)
    {
        $internalAudit= InternalAudit::find($id);
        $array=["internalAudit"=>$internalAudit];
       
        return response()->json($array);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sgc  $sgc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sgc $sgc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sgc  $sgc
     * @return \Illuminate\Http\Response
     */
    public function showFiles($id)
    {
        $files = InternalAudit::find($id)->auditFiles;
        
        $msg="";
        $error=false;
        

        $array=["msg"=>$msg, "error"=>$error, "files"=>$files];

        return response()->json($array);
    }
}
