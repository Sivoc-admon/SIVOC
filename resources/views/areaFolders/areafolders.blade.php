@extends('adminlte::page')

@section('title', 'SIVOC-USUARIOS')

@section ( ' plugins.Datatables ' , true)

@section('content_header')
    <h1 class="m-0 text-dark">{{ ucwords($area) }}</h1>
@stop

@section('content')
    <input type="hidden" id="hiddenAriaId" value="{{ $folders[0]['area_id'] }}">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-primary" onclick="newFolder({{ $folders[0]['area_id'] }}, 0)">
                        Agregar carpeta en el primer nivel
                    </button>

                    <input type="file" class="btn btn-warning" id="files_{{ $folders[0]['area_id'] }}_0" onchange="newFile({{ $folders[0]['area_id'] }}, 0)" multiple />
                    @include('areafolders.modals')
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4>Carpetas</h4>
                    <div class="form-group" id="divFolders">
                        <select id="selectNivel{{ $folders[0]['nivel'] }}" class="form-control" onchange="getFoldersAndFiles({{ $folders[0]['area_id'] }}, {{ $folders[0]['nivel'] }})">
                            <option value="">Seleccione</option>
                            @foreach($folders as $folder)
                            <option value="{{ $folder['id'] }}">{{ $folder['name'] }}</option>
                            @endforeach
                        </select><br>
                        <button id="btnLevel1" type="button" class="btn btn-primary form-button" onclick="newFolder({{ $folders[0]['area_id'] }}, {{ $folders[0]['nivel'] }})"
                          style="display:none;">
                          Agregar carpeta</button>
                        <input type="file" class="btn btn-warning" id="files_{{ $folders[0]['area_id'] }}_{{ $folders[0]['nivel'] }}" onchange="newFile({{ $folders[0]['area_id'] }}, {{ $folders[0]['nivel'] }})" multiple style="display:none;"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- class="table table-striped table-bordered" -->
                    <table id="tableDocuments" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Ruta del archivo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tableFiles">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#tableDocuments').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    //'csv', 'excel', 'pdf'
                ]
            });
        } );
</script>
<script src="{{ asset('vendor/myjs/areafolders.js') }}"></script>
@stop