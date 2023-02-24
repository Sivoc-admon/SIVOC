<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Project;
use App\ListaMaterialesFolder;
use App\ListaMaterialesFile;
use App\Imports\MaterialesImport;
use App\ListaMateriales;
use App\ListaCambios;

class listaMaestraController extends Controller
{
    public function index()
    {
        $projects = Project::get();
        $folders = $this->showFolders();
        //dd($folders);

        return view('listaMaestra.index', compact('projects', 'folders'));

    }

    public function uploadFile(Request $request, $nameProject)
    {
        $error=false;
        $msg="";
        if ($request->hasFile('file0')) {
            $folder = ListaMaterialesFolder::where('name','=', $nameProject)->first();
            //$r = $this->getPathFolder($request->folder);
            $pathFile = 'public/Documents/Lista_Maestra/'.$nameProject.'/';
            //dd($folder);


            for ($i=0; $i <$request->tamanoFiles ; $i++) {
                $nombre="file".$i;
                $archivo = $request->file($nombre);


                $listaMaterialesFile=ListaMaterialesFile::create([
                    'id_lista_materiales_folder' => $folder->id,
                    'name' => $archivo->getClientOriginalName(),
                    'ruta' => 'storage/Documents/Lista_Maestra/'.$nameProject.'/',

                ]);
                $path = $archivo->storeAs(
                    $pathFile, $archivo->getClientOriginalName()
                );
            }

            if ($listaMaterialesFile->save()) {
                $msg="Registro guardado con exito";
            }else{
                $error=true;
                $msg="Error al guardar archvio";
            }
            (new MaterialesImport($folder->id_project, $listaMaterialesFile->id))->import($path);
        }else{
            $error=true;
            $msg="No selecciono ningun archivo";
        }





        $array=["msg"=>$msg, "error"=>$error];

        return response()->json($array);
    }

    public function showFolders()
    {

        $folders = ListaMaterialesFolder::all();

        $tree ="<ul>";
        foreach ($folders as $folder) {
            $tree.="<li>".$folder->name."<i style='padding-left: 5px; color: orange;' class='fas fa-folder' onClick='showModal(\"ModalShowFoldersProject\",".$folder->id.", \"folder\")'></i><i style='padding-left: 5px; color: darkcyan;' class='fas fa-file' onClick='showModal(\"ModalShowFilesProject\",".$folder->id.", \"file\")'></i>";

            if(count($folder->files)){

                $tree .="<ul>";
                foreach ($folder->files as $file) {
                    $tree .= "<li data-jstree='{\"disabled\":true, \"opened\":false, \"type\":\"file\"}'><a href='$file->ruta$file->name' target='_blank'>$file->name</a></li>";
                }
                $tree .="</ul>";

            }
            $tree .="</li>";

        }
        $tree .= "</ul>";
        return $tree;
    }

    public function childView($folder, $idProject)
    {
        $html = "<ul class='nested'>";
        if(count($folder->files)){
            foreach ($folder->files as $file) {
                $storage =asset($file->ruta.$file->name);
                $html .= "<li><a href=".$storage." target='_blank'>$file->name</a><i style='padding-left: 5px; color: red;' class='fas fa-minus-square' onClick='eliminarArchivo(".$file->id.")'></i></li>";
            }

        }
        foreach ($folder->childs as $arr) {
            if(count($arr->childs)){
                $html .= "<li>";
                $html .= "<span class='caret'>".$arr->name."</span><i style='padding-left: 5px; color: orange;' class='fas fa-folder' onClick='showModal(\"ModalShowFoldersProject\",".$arr->id.", ".$idProject.", \"folder\")'></i><i style='padding-left: 5px; color: darkcyan;' class='fas fa-file' onClick='showModal(\"ModalShowFilesProject\",".$arr->id.", ".$idProject.", \"file\")'></i>";
                $html .= $this->childView($arr, $idProject);
                if(count($arr->files)){
                    foreach ($arr->files as $file) {
                        $html .= "<li><a href='$file->ruta$file->name' target='_blank'>$file->name</a></li>";
                    }

                }

                $html .= "</li>";

            }else{
                $html .= "<li>";
                $html .= "<span>".$arr->name."</span><i style='padding-left: 5px; color: orange;' class='fas fa-folder' onClick='showModal(\"ModalShowFoldersProject\",".$arr->id.", ".$idProject.", \"folder\")'></i><i style='padding-left: 5px; color: darkcyan;' class='fas fa-file' onClick='showModal(\"ModalShowFilesProject\",".$arr->id.", ".$idProject.", \"file\")'></i>";
                if(count($arr->files)){
                    $html .= "<ul>";
                    foreach ($arr->files as $file) {
                        $html .= "<li><a href='$file->ruta$file->name' target='_blank'>$file->name</a><i style='padding-left: 5px; color: red;' class='fas fa-minus-square' onClick='eliminarArchivo(".$file->id.")'></i></li>";
                    }
                    $html .= "</ul>";

                }
                $html .= "</li>";
            }
        }
        $html .= "</ul>";
        return $html;
    }

    public function createFolder(Request $request)
    {
        $projectName = Project::find($request->sltProyecto)->name_project;

        $folder = new ListaMaterialesFolder;

        $folder->id_project = $request->sltProyecto;
        $folder->name = $projectName;
        $folder->id_padre = $request->hiddenInputIdPadre;

        $folder->save();

        //$r = $this->getPathFolder($request->id_padre);

        Storage::makeDirectory('public/Documents/Lista_Maestra/'. $projectName .'/');

        return response()->json(['data' => "success"], Response::HTTP_OK);
        //return redirect()->action([ProjectController::class, 'index']);
    }

    private function getPathFolder($folderId){

        $idPadre = -70;
        $path = '';
        if ($folderId != 0) {
            do {
                $folder = ListaMaterialesFolder::where('id', $folderId)->get()[0];
                $idPadre = intval($folder->id_padre);
                $nameFolder = $folder->name;
                $folderId = $idPadre;
                $path = $nameFolder . '/' . $path;
            } while ($idPadre != 0);
        }
        return '/' . $path;
    }

    public function show($name_project)
    {
        $project = Project::where('name_project', '=', $name_project)->first();
        /*$listaMateriales = ListaMateriales::where('id_project', '=', $project->id)
        ->groupBy('folio')
        ->selectRaw('*, sum(cantidad)')->get(); */

        $listaMateriales = DB::table('lista_materiales')
                ->selectRaw('id, folio, description, modelo, fabricante, SUM(cantidad) as cantidad, unidad')
                ->where('id_project', '=', $project->id)
                ->groupByRaw('folio')
                ->get();
        $secciones = DB::table('lista_materiales_files as f')
        ->join('lista_materiales_folders as m', 'f.id_lista_materiales_folder', '=', 'm.id')
        ->select('f.name', 'f.id')
        ->where('m.id_project', '=', $project->id)
        ->get();
        $d =$project->created_at;
        $d->format('d/m/Y');
        $msg="";
        //dd($d->format('d/m/Y'));
        $error =false;
        $array=["msg"=>$msg, "error"=>$error, 'listaMateriales'=>$listaMateriales, 'project'=>$name_project, 'project_date'=> $d->format('d/m/Y'), 'secciones'=>$secciones];
        return response()->json($array);
    }

    //se obtiene la lista de materiales por seccion
    public function getSeccion($id)
    {
        $listaMateriales = DB::table('lista_materiales')
                ->selectRaw('id , folio, description, modelo, fabricante, SUM(cantidad) as cantidad, unidad')
                ->where('id_seccion', '=', $id)
                ->groupByRaw('folio')
                ->get();
        $listaFinal= collect([]);
        $listaFinalCambios= collect([]);
        $totalTablas=0;
        foreach ($listaMateriales as $key ) {
            $listaCambios = ListaCambios::where('id_lista_materiales', '=', $key->id)->orderBy('id', 'asc')->get();

            $ultimoCambio = ListaCambios::where('id_lista_materiales', '=', $key->id)->orderBy('id', 'desc')->first();




            if(!is_null($listaCambios)){

                $max = count($listaCambios);

                if($totalTablas < $max){
                    $totalTablas = $max;
                }
                $listaFinal->push(['id'=>$key->id,
                    'folio'=>$key->folio,
                    'description'=>$key->description,
                    'modelo'=>$key->modelo,
                    'fabricante'=>$key->fabricante,
                    'cantidad'=>$key->cantidad,
                    'unidad'=>$key->unidad,
                    'cambio'=>'Cambiar',
                ]);
                // se genera la lista para mostarar en distintas tablas si existe mas de un cambio del mismo TAB
                //contador
                $cont = 0;
                foreach ($listaCambios as $value ) {
                    $cont++;
                    //le damos formato a la fecha de modificacion
                    $date = $value->created_at;

                    $listaFinalCambios->push(['id'=>$value->id,
                        'folio'=>$value->folio,
                        'description'=>$value->description,
                        'modelo'=>$value->modelo,
                        'fabricante'=>$value->fabricante,
                        'cantidad'=>$value->cantidad,
                        'unidad'=>$value->unidad,
                        'cambio'=>$value->tipo,
                        'tabla'=> $cont,
                        'idFolioPrincipal' =>$key->id,
                        'folioPrincipal' => $key->folio,
                        'fecha' => $date->format('Y-m-d'),
                    ]);

                }


            }else{
                $listaFinal->push(['id'=>$key->id,
                    'folio'=>$key->folio,
                    'description'=>$key->description,
                    'modelo'=>$key->modelo,
                    'fabricante'=>$key->fabricante,
                    'cantidad'=>$key->cantidad,
                    'unidad'=>$key->unidad,
                    'cambio'=>null,
                ]);
            }

        }

        $msg="";

        $error =false;

        $array=["msg"=>$msg, "error"=>$error, 'listaMateriales'=>$listaFinal, 'listaFinalCambios'=>$listaFinalCambios ,'totalTablas'=>$totalTablas];
        return response()->json($array);
    }

    //CONSULTA EL MATERIAL PARA PODER EDITARLO
    public function getMaterial($id)
    {
        $material = ListaMateriales::find($id);
        $materiales = DB::table('lista_materiales')
        ->select('folio')
        ->distinct()
        ->get();
        $unidades = DB::table('lista_materiales')
        ->select('unidad')
        ->distinct()
        ->get();

        $msg="";

        $error =false;

        $array=["msg"=>$msg, "error"=>$error, 'material'=>$material, 'materiales'=>$materiales, 'unidades'=>$unidades];
        return response()->json($array);
    }

    public function createMaterialModificacion(Request $request)
    {
        $user = auth()->user();
        $listaCambios = new ListaCambios;

        $listaCambios->id_lista_materiales = $request->id;
        $listaCambios->id_user = $user->id;
        $listaCambios->folio = $request->folio;
        $listaCambios->description = $request->descripcion;
        $listaCambios->modelo = $request->modelo;
        $listaCambios->fabricante = $request->fabricante;
        $listaCambios->cantidad = $request->cantidad;
        $listaCambios->unidad = $request->unidad;
        $listaCambios->tipo = $request->accion;

        $listaCambios->save();

        //return redirect()->action([ProjectController::class, 'index']);
        return redirect()->action([ListaMaestraController::class, 'getSeccion'],  ['seccion' => $request->seccion]);

    }
}
