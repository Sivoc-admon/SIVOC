<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;
use App\AreaDocument;
use App\FolderArea;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

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
        $aria = Area::where('name', 'like', '%' . $area . '%')->take(1)->get();

        $folders = [];
        if (in_array($area, $ariasValidas)) {
            foreach ($aria as $ariax) {
                $areaId = $ariax->id;
                $folders = $this->getFolderByNivel($areaId, 1, 0);
                $folders->each(function ($f) {
                    $f->areaDocuments;
                });
                $folders->files = AreaDocument::where('area_id', $areaId)->where('folder_area_id', 0)->get();
                ##dd($folders);
            }
        } else {
            $area = 'almacen';
        }
        return view('areafolders.areafolders')->with('folders', $folders->toArray())->with('area', $area);
    }

    public function filesLevelZero($area, $folderId)
    {
        $aria = Area::where('id', $area)->take(1)->get();

        $folders = [];
        foreach ($aria as $ariax) {
            $areaId = $ariax->id;
            $folders = AreaDocument::where('area_id', $areaId)->where('folder_area_id', $folderId)->get();
        }
        return response()->json($folders, Response::HTTP_OK);
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

    private function getFolderByNivel($areaId, $nivel, $idPadre)
    {

        $folders = FolderArea::where('area_id', $areaId)->where('nivel', $nivel)->where('id_padre', $idPadre)->get();
        return $folders;
    }

    public function getFoldersAndFiles($areaId, $nivel, $idPadre)
    {
        $nivel = intval($nivel);
        $folders = $this->getFolderByNivel($areaId, $nivel, $idPadre);
        $folders->each(function ($f) {
            $f->areaDocuments;
        });
        return response()->json(['data' => $folders], Response::HTTP_OK);
    }

    public function createFolder($areaId, $nivel, Request $request)
    {
        sleep(2);
        $folderName = $request->get('folderName');
        $idFolder = $request->get('idFolder');
        $r = $this->getPathFolder($idFolder);
        $area = Area::where('id', $areaId)->get()[0];
        $folderPadre = ($idFolder != 0) ? FolderArea::where('id', $idFolder)->get()[0] : $idFolder;
        $folderAreaName = $area->name;
        $folderArea = new FolderArea;
        $folderArea->area_id = $areaId;
        $folderArea->nivel = $nivel;
        $folderArea->name = $folderName;
        $folderArea->id_padre = ($idFolder != 0) ? $folderPadre->id : 0;

        $folderArea->save();
        Storage::makeDirectory('public/Documents/' . $folderAreaName . $r . $folderName);
        sleep(2);
        return response()->json(['data' => array('msje' => "Carpeta \"$folderName\" creada correctamente.")], Response::HTTP_OK);
    }

    private function getPathFolder($folderId)
    {

        $idPadre = -70;
        $path = '';
        if ($folderId != 0) {
            do {
                $folder = FolderArea::where('id', $folderId)->get()[0];
                $idPadre = intval($folder->id_padre);
                $nameFolder = $folder->name;
                $folderId = $idPadre;
                $path = $nameFolder . '/' . $path;
            } while ($idPadre != 0);
        }
        return '/' . $path;
    }

    public function createFiles($areaId, $nivel, Request $request)
    {
        $idFolder = $request->folderId;
        $area = Area::where('id', $areaId)->get()[0];
        $folderAreaName = $area->name;
        $r = $this->getPathFolder($idFolder);
        $pathFile = 'public/Documents/' . $folderAreaName . $r;
        if ($request->TotalFiles > 0) {

            for ($x = 0; $x < $request->TotalFiles; $x++) {
                if ($request->hasFile('files' . $x)) {
                    $file = $request->file('files' . $x);
                    $path = $pathFile . '/' . $file->getClientOriginalName();
                    $name = $file->getClientOriginalName();
                    Storage::disk('local')->put($path, $request->file);
                    $areaDocument = new AreaDocument;
                    $areaDocument->area_id = $areaId;
                    $areaDocument->folder_area_id = $idFolder;
                    $areaDocument->name = $name;
                    $areaDocument->ruta = 'storage/app/' . $pathFile;
                    $areaDocument->save();
                }
            }
            return response()->json(['success' => 'Subida de archivos correcta.']);
        } else {
            return response()->json(["message" => "No se recibió ningún archivo."], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        #*/
    }
}
