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
                    <!--<button type="button" class="btn btn-primary" onclick="newFolder({{ $folders[0]['area_id'] }}, 0)">
                        Agregar carpeta en el primer nivel
                    </button>

                    <input type="file" class="btn btn-warning" id="files_{{ $folders[0]['area_id'] }}_0" onchange="newFile({{ $folders[0]['area_id'] }}, 0)" multiple />
                -->
                    @switch($area)
                        @case('almacen')
                            @if (Auth::user()->hasAnyRole(['almacen', 'admin']))
                                <button type="button" class="btn btn-primary" onclick="newFolder({{ $folders[0]['area_id'] }}, 0)">
                                    Agregar carpeta en el primer nivel
                                </button>
            
                                <input type="file" class="btn btn-warning" id="files_{{ $folders[0]['area_id'] }}_0" onchange="newFile({{ $folders[0]['area_id'] }}, 0)" multiple />
                            @endif
                            @break
                        @case('calidad')
                            @if (Auth::user()->hasAnyRole(['calidad', 'admin']))
                                <button type="button" class="btn btn-primary" onclick="newFolder({{ $folders[0]['area_id'] }}, 0)">
                                    Agregar carpeta en el primer nivel
                                </button>
            
                                <input type="file" class="btn btn-warning" id="files_{{ $folders[0]['area_id'] }}_0" onchange="newFile({{ $folders[0]['area_id'] }}, 0)" multiple />
                            @endif
                            @break
                        @case('operaciones')
                            @if (Auth::user()->hasAnyRole(['operaciones', 'admin']))
                                <button type="button" class="btn btn-primary" onclick="newFolder({{ $folders[0]['area_id'] }}, 0)">
                                    Agregar carpeta en el primer nivel
                                </button>
            
                                <input type="file" class="btn btn-warning" id="files_{{ $folders[0]['area_id'] }}_0" onchange="newFile({{ $folders[0]['area_id'] }}, 0)" multiple />
                            @endif
                            @break
                        @case('compras')
                            @if (Auth::user()->hasAnyRole(['compras', 'admin', 'finanzas']))
                                <button type="button" class="btn btn-primary" onclick="newFolder({{ $folders[0]['area_id'] }}, 0)">
                                    Agregar carpeta en el primer nivel
                                </button>
            
                                <input type="file" class="btn btn-warning" id="files_{{ $folders[0]['area_id'] }}_0" onchange="newFile({{ $folders[0]['area_id'] }}, 0)" multiple />
                            @endif
                            @break
                        @case('direccion')
                            @if (Auth::user()->hasAnyRole(['direccion', 'admin']))
                                <button type="button" class="btn btn-primary" onclick="newFolder({{ $folders[0]['area_id'] }}, 0)">
                                    Agregar carpeta en el primer nivel
                                </button>
            
                                <input type="file" class="btn btn-warning" id="files_{{ $folders[0]['area_id'] }}_0" onchange="newFile({{ $folders[0]['area_id'] }}, 0)" multiple />
                            @endif
                            @break
                        @case('finanzas')
                            @if (Auth::user()->hasAnyRole(['finanzas', 'admin']))
                                <button type="button" class="btn btn-primary" onclick="newFolder({{ $folders[0]['area_id'] }}, 0)">
                                    Agregar carpeta en el primer nivel
                                </button>
            
                                <input type="file" class="btn btn-warning" id="files_{{ $folders[0]['area_id'] }}_0" onchange="newFile({{ $folders[0]['area_id'] }}, 0)" multiple />
                            @endif
                            @break
                        @case('ingenieria')
                            @if (Auth::user()->hasAnyRole(['ingenieria', 'admin']))
                                <button type="button" class="btn btn-primary" onclick="newFolder({{ $folders[0]['area_id'] }}, 0)">
                                    Agregar carpeta en el primer nivel
                                </button>
            
                                <input type="file" class="btn btn-warning" id="files_{{ $folders[0]['area_id'] }}_0" onchange="newFile({{ $folders[0]['area_id'] }}, 0)" multiple />
                            @endif
                            @break
                        @case('manufactura')
                            @if (Auth::user()->hasAnyRole(['manufactura', 'admin']))
                                <button type="button" class="btn btn-primary" onclick="newFolder({{ $folders[0]['area_id'] }}, 0)">
                                    Agregar carpeta en el primer nivel
                                </button>
            
                                <input type="file" class="btn btn-warning" id="files_{{ $folders[0]['area_id'] }}_0" onchange="newFile({{ $folders[0]['area_id'] }}, 0)" multiple />
                            @endif
                            @break
                        @case('recursos humanos')
                            @if (Auth::user()->hasAnyRole(['rh', 'admin']))
                                <button type="button" class="btn btn-primary" onclick="newFolder({{ $folders[0]['area_id'] }}, 0)">
                                    Agregar carpeta en el primer nivel
                                </button>
            
                                <input type="file" class="btn btn-warning" id="files_{{ $folders[0]['area_id'] }}_0" onchange="newFile({{ $folders[0]['area_id'] }}, 0)" multiple />
                            @endif
                            @break
                        @case('ventas')
                            @if (Auth::user()->hasAnyRole(['ventas', 'admin', 'finanzas']))
                                <button type="button" class="btn btn-primary" onclick="newFolder({{ $folders[0]['area_id'] }}, 0)">
                                    Agregar carpeta en el primer nivel
                                </button>
            
                                <input type="file" class="btn btn-warning" id="files_{{ $folders[0]['area_id'] }}_0" onchange="newFile({{ $folders[0]['area_id'] }}, 0)" multiple />
                            @endif
                            @break
                        @case('servicio')
                            @if (Auth::user()->hasAnyRole(['servicio', 'admin']))
                            <button type="button" class="btn btn-primary" onclick="newFolder({{ $folders[0]['area_id'] }}, 0)">
                                Agregar carpeta en el primer nivel
                            </button>
        
                            <input type="file" class="btn btn-warning" id="files_{{ $folders[0]['area_id'] }}_0" onchange="newFile({{ $folders[0]['area_id'] }}, 0)" multiple />
                        @endif
                        @break
                            @break
                        @default
                            
                    @endswitch

                    
                    
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
                    @if(!isset($folders[0]['empty']))
                        @switch($area)
                            @case('finanzas')
                                @if (Auth::user()->hasAnyRole(['finanzas', 'admin']))
                                    <select id="selectNivel{{ $folders[0]['nivel'] }}" class="form-control" onchange="getFoldersAndFiles({{ $folders[0]['area_id'] }}, {{ $folders[0]['nivel'] }})">
                                        <option value="">Seleccione</option>
                                        @foreach($folders as $folder)
                                        <option value="{{ $folder['id'] }}">{{ $folder['name'] }}</option>
                                        @endforeach
                                    </select><br>
                                    <button id="btnLevel1" type="button" class="btn btn-primary form-button" onclick="newFolder({{ $folders[0]['area_id'] }}, {{ $folders[0]['nivel'] }})"
                                    style="display:none;">
                                    Agregar carpeta</button>
                                    <button id="btnLevelModify1" type="button" class="btn btn-info form-button" onclick="cambiaNombreFolder({{$folders[0]['id']}})"
                                    style="display:none;">
                                    Cambiar nombre a</button>
                                    <input type="file" class="btn btn-warning" id="files_{{ $folders[0]['area_id'] }}_{{ $folders[0]['nivel'] }}" onchange="newFile({{ $folders[0]['area_id'] }}, {{ $folders[0]['nivel'] }})" multiple style="display:none;"/>
                                @endif
                                @break
                            @case('recursos humanos')
                                @if (Auth::user()->hasAnyRole(['recursos humanos', 'admin']))
                                    <select id="selectNivel{{ $folders[0]['nivel'] }}" class="form-control" onchange="getFoldersAndFiles({{ $folders[0]['area_id'] }}, {{ $folders[0]['nivel'] }})">
                                        <option value="">Seleccione</option>
                                        @foreach($folders as $folder)
                                        <option value="{{ $folder['id'] }}">{{ $folder['name'] }}</option>
                                        @endforeach
                                    </select><br>
                                    <button id="btnLevel1" type="button" class="btn btn-primary form-button" onclick="newFolder({{ $folders[0]['area_id'] }}, {{ $folders[0]['nivel'] }})"
                                    style="display:none;">
                                    Agregar carpeta</button>
                                    <button id="btnLevelModify1" type="button" class="btn btn-info form-button" onclick="cambiaNombreFolder({{$folders[0]['id']}})"
                                    style="display:none;">
                                    Cambiar nombre a</button>
                                    <input type="file" class="btn btn-warning" id="files_{{ $folders[0]['area_id'] }}_{{ $folders[0]['nivel'] }}" onchange="newFile({{ $folders[0]['area_id'] }}, {{ $folders[0]['nivel'] }})" multiple style="display:none;"/>
                                @endif
                                @break
                            @case('ventas')
                                @if (Auth::user()->hasAnyRole(['ventas', 'admin', 'ingenieria', 'finanzas']))
                                    <select id="selectNivel{{ $folders[0]['nivel'] }}" class="form-control" onchange="getFoldersAndFiles({{ $folders[0]['area_id'] }}, {{ $folders[0]['nivel'] }})">
                                        <option value="">Seleccione</option>
                                        @foreach($folders as $folder)
                                        <option value="{{ $folder['id'] }}">{{ $folder['name'] }}</option>
                                        @endforeach
                                    </select><br>
                                    <button id="btnLevel1" type="button" class="btn btn-primary form-button" onclick="newFolder({{ $folders[0]['area_id'] }}, {{ $folders[0]['nivel'] }})"
                                    style="display:none;">
                                    Agregar carpeta</button>
                                    <button id="btnLevelModify1" type="button" class="btn btn-info form-button" onclick="cambiaNombreFolder({{$folders[0]['id']}})"
                                    style="display:none;">
                                    Cambiar nombre a</button>
                                    <input type="file" class="btn btn-warning" id="files_{{ $folders[0]['area_id'] }}_{{ $folders[0]['nivel'] }}" onchange="newFile({{ $folders[0]['area_id'] }}, {{ $folders[0]['nivel'] }})" multiple style="display:none;"/>
                                @endif
                                @break
                            @case('ingenieria')
                                @if (Auth::user()->hasAnyRole(['ingenieria', 'admin', 'manufactura', 'almacen', 'compras']))
                                    <select id="selectNivel{{ $folders[0]['nivel'] }}" class="form-control" onchange="getFoldersAndFiles({{ $folders[0]['area_id'] }}, {{ $folders[0]['nivel'] }})">
                                        <option value="">Seleccione</option>
                                        @foreach($folders as $folder)
                                        <option value="{{ $folder['id'] }}">{{ $folder['name'] }}</option>
                                        @endforeach
                                    </select><br>
                                    <button id="btnLevel1" type="button" class="btn btn-primary form-button" onclick="newFolder({{ $folders[0]['area_id'] }}, {{ $folders[0]['nivel'] }})"
                                    style="display:none;">
                                    Agregar carpeta</button>
                                    <button id="btnLevelModify1" type="button" class="btn btn-info form-button" onclick="cambiaNombreFolder({{$folders[0]['id']}})"
                                    style="display:none;">
                                    Cambiar nombre a</button>
                                    <input type="file" class="btn btn-warning" id="files_{{ $folders[0]['area_id'] }}_{{ $folders[0]['nivel'] }}" onchange="newFile({{ $folders[0]['area_id'] }}, {{ $folders[0]['nivel'] }})" multiple style="display:none;"/>
                                @endif
                                @break
                            @default
                                <select id="selectNivel{{ $folders[0]['nivel'] }}" class="form-control" onchange="getFoldersAndFiles({{ $folders[0]['area_id'] }}, {{ $folders[0]['nivel'] }})">
                                    <option value="">Seleccione</option>
                                    @foreach($folders as $folder)
                                    <option value="{{ $folder['id'] }}">{{ $folder['name'] }}</option>
                                    @endforeach
                                </select><br>
                                <button id="btnLevel1" type="button" class="btn btn-primary form-button" onclick="newFolder({{ $folders[0]['area_id'] }}, {{ $folders[0]['nivel'] }})"
                                style="display:none;">
                                Agregar carpeta</button>
                                <button id="btnLevelModify1" type="button" class="btn btn-info form-button" onclick="cambiaNombreFolder({{$folders[0]['id']}})"
                                style="display:none;">
                                Cambiar nombre a</button>
                                <input type="file" class="btn btn-warning" id="files_{{ $folders[0]['area_id'] }}_{{ $folders[0]['nivel'] }}" onchange="newFile({{ $folders[0]['area_id'] }}, {{ $folders[0]['nivel'] }})" multiple style="display:none;"/>
                                
                        @endswitch
                        
                    @endif
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
                                <th>Fecha registro</th>
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
