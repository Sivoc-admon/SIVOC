<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Project;
use App\ListaMaterialesFolder;
use App\ListaMaterialesFile;

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
}
