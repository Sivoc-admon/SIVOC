<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;
use App\AreaDocument;
use App\FolderArea;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AreaDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($area)
    {
        $ariasValidas = ['almacen', 'calidad', 'control operacional', 'compras', 'direccion', 'finanzas', 'ingenieria', 'manufactura', 'recursos humanos', 'ventas'];
        $aria = Area::where('name', 'like', '%'.$area.'%')->take(1)->get();

        if(in_array($area, $ariasValidas)){
            foreach($aria as $ariax){
                #dd($ariax->id);
                $areaId = $ariax->id;
                $folders = $this->getFolderByNivel($areaId, 1);
                $folders->each(function($f){
                    $f->areaDocuments;
                });
                #dd($folders->toArray());
            }
        }
        return view('areafolders.areafolders')->with('folders', $folders->toArray());
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
        
        $areaDocument = new AreaDocument;
       
        $areaDocument->area_id = $request->input('area_id');
        $areaDocument->name = $request->input('name');
        $areaDocument->ruta = $request->input('ruta');
        
        $areaDocument->save();
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
        //
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

    private function getFolderByNivel($areaId, $nivel){

        $folders = FolderArea::where('area_id', $areaId)->where('nivel', $nivel)->get();
        return $folders;
    }

    public function getFoldersAndFiles($areaId, $nivel){
        $folders = $this->getFolderByNivel($areaId, $nivel);
        $folders->each(function($f){
            $f->areaDocuments;
        });

        #return $this->successResponse($folders);
        return response()->json(['data' => $folders], Response::HTTP_OK);
    }
}
