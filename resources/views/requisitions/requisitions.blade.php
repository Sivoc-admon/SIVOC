@extends('adminlte::page')

@section('title', 'SIVOC-PROYECTOS')

@section('content_header')
    <link rel="stylesheet" href="{{ asset("vendor/mycss/style.css") }}">
    @section('css')
        <style>
            ul, #myUL {
                list-style-type: none;
            }

            #myUL {
                margin: 0;
                padding: 0;
            }

            .caret {
                cursor: pointer;
                -webkit-user-select: none; /* Safari 3.1+ */
                -moz-user-select: none; /* Firefox 2+ */
                -ms-user-select: none; /* IE 10+ */
                user-select: none;
            }

            .caret::before {
                content: "\25B6";
                color: red;
                display: inline-block;
                margin-right: 6px;
            }

            .caret-down::before {
                -ms-transform: rotate(90deg); /* IE 9 */
                -webkit-transform: rotate(90deg); /* Safari */'
                transform: rotate(90deg);
            }

            .nested {
                display: none;
            }

            .active {
                display: block;
            }
            .modal-lg {
                max-width: 100%;
            }

            /*Vertical Steps*/
            .list-group.vertical-steps{
                padding-left:10px;
            }
            .list-group.vertical-steps .list-group-item{
                border:none;
                border-left:3px solid #ece5dd;
                box-sizing:border-box;
                border-radius:0;
                counter-increment: step-counter;
                padding-left:20px;
                padding-right:0px;
                padding-bottom:20px;
                padding-top:0px;
            }
            .list-group.vertical-steps .list-group-item.active{
                background-color:transparent;
                color:inherit;
            }
            .list-group.vertical-steps .list-group-item:last-child{
                border-left:3px solid transparent;
                padding-bottom:0;
            }
            .list-group.vertical-steps .list-group-item::before {
                border-radius: 50%;
                background-color:#ece5dd;
                color:#555;
                content: counter(step-counter);
                display:inline-block;
                float:left;
                height:25px;
                line-height:25px;
                margin-left:-35px;
                text-align:center;
                width:25px;
            }
            .list-group.vertical-steps .list-group-item span,
            .list-group.vertical-steps .list-group-item a{
                display:block;
                overflow:hidden;
                padding-top:2px;
            }

            /*Active/ Completed States*/
            .list-group.vertical-steps .list-group-item.active::before{
                background-color:#0052c2;
                color:#fff;
            }
            .list-group.vertical-steps .list-group-item.completed{
                border-left:3px solid #0052c2;
            }
            .list-group.vertical-steps .list-group-item.completed::before{
                background-color:#0052c2;
                color:#fff;
            }
            .list-group.vertical-steps .list-group-item.completed:last-child{
                border-left:3px solid transparent;
            }
        </style>
    @stop
    <h1 class="m-0 text-dark">Requisiciones</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(Auth::user()->hasAnyRole(['admin', 'almacen', 'finanzas ', 'calidad', 'compras', 'tesoreria', 'manufactura', 'pruebas', 'ingenieria', 'ventas', 'direccion', 'coordinador comercial', 'coordinador operacional', 'coordinador de finanzas', 'coordinador de calidad']))

                    <span data-toggle="modal" data-target="#modalCreateRequisition" data-backdrop='static'>
                        <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Nueva Requisición" onclick="newRequisition()">
                            <i class="fas fa-plus"></i> Nueva Requisición
                        </button>
                    </span>
                    <a class="btn btn-primary" href="{{ url('/requisitions') }}" role="button"> <i class="fas fa-list"></i>Listar todas</a>

                    <button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Entregadas" onclick="listaRequisiciones('Entregadas')">
                        <i class="fas fa-check"></i> Entregadas
                    </button>


                    <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Canceladas" onclick="listaRequisiciones('Canceladas')">
                        <i class="fas fa-ban"></i> Canceladas
                    </button>

                    @endif
                    @include('requisitions.create_requisition')
                    @include('requisitions.files')
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <table id="tableRequisitions"  class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Area</th>
                                <th>Proyecto</th>
                                <th>Fecha</th>
                                <th>Estatus</th>
                                <th>Comentario</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($requisitions)
                                @foreach ($requisitions as $requisiton)
                                    <tr>
                                        <td>{{ $requisiton->no_requisition }}</td>
                                        <td>{{ $requisiton->name }} {{ $requisiton->last_name }}</td>
                                        @foreach ($areas as $area)
                                            @if($requisiton->id_area == $area->id)
                                                <td>{{ $area->name }}</td>

                                            @endif
                                        @endforeach
                                        <td>
                                            {{$requisiton->nom_proyecto}}

                                        </td>
                                        <td>{{ $requisiton->created_at }}</td>
                                        @if ($requisiton->status == "Cancelada")
                                            <td style="color:red">{{ $requisiton->status }}</td>
                                        @else
                                            <td>{{ $requisiton->status }}</td>
                                        @endif
                                        <td>{{ $requisiton->comment }}</td>


                                        @if (Auth::user()->hasAnyRole(['admin', 'almacen', 'calidad', 'compras', 'manufactura', 'pruebas', 'ingenieria', 'ventas', 'tesoreria', 'direccion', 'finanzas', 'coordinador comercial', 'coordinador operacional', 'coordinador finanzas', 'coordinador de calidad']))
                                            <td>
                                                <span data-toggle="modal" data-target="#modalCreateRequisition" data-backdrop='static'>
                                                    <button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Editar requisicion" onclick="showRequisition({{$requisiton->id}})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </span>
                                                <!-- <span data-toggle="modal" data-target="#modalFilesRequisition">
                                                    <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Archivos" onclick="showModalFile({{$requisiton->id}})">
                                                        <i class="fas fa-list"></i>
                                                    </button>
                                                </span> -->
                                                <span data-toggle="modal" data-target="#modalHistorial">
                                                    <button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Historial" onclick="history({{$requisiton->id}})">
                                                        <i class="fas fa-clock"></i>
                                                    </button>
                                                </span>
                                                @if (Auth::user()->hasAnyRole(['admin', 'direccion', 'almacen', 'calidad', 'finanzas', 'pruebas', 'ingenieria', 'ventas', 'manufactura', 'coordinador comercial', 'coordinador operacional', 'coordinador finanzas', 'coordinador de calidad', 'compras']))
                                                    @switch($requisiton->status)
                                                        @case("Creada")
                                                                @switch($requisiton->id_area)
                                                                    @case(1)
                                                                        @if ($requisiton->id_user == auth()->user()->id || Auth::user()->hasAnyRole(['admin']))
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Solicitada')">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </span>
                                                                            <span >
                                                                                <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Cancelar" onclick="regresar({{$requisiton->id}}, 'Cancelada')">
                                                                                    <i class="fas fa-minus-square"></i>
                                                                                </button>
                                                                            </span>
                                                                        @endif
                                                                        @break
                                                                    @case(2)
                                                                            @if ($requisiton->id_user == auth()->user()->id || Auth::user()->hasAnyRole('admin'))
                                                                                <span >
                                                                                    <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Solicitada')">
                                                                                        <i class="fas fa-check"></i>
                                                                                    </button>
                                                                                </span>
                                                                                <span >
                                                                                    <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Cancelar" onclick="regresar({{$requisiton->id}}, 'Cancelada')">
                                                                                        <i class="fas fa-minus-square"></i>
                                                                                    </button>
                                                                                </span>
                                                                            @endif
                                                                        @break
                                                                    @case(3)
                                                                        @if ($requisiton->id_user == auth()->user()->id || Auth::user()->hasAnyRole('admin'))
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Solicitada')">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </span>
                                                                            <span >
                                                                                <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Cancelar" onclick="regresar({{$requisiton->id}}, 'Cancelada')">
                                                                                    <i class="fas fa-minus-square"></i>
                                                                                </button>
                                                                            </span>
                                                                        @endif
                                                                        @break
                                                                    @case(5)
                                                                        @if ($requisiton->id_user == auth()->user()->id || Auth::user()->hasAnyRole('admin'))
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Solicitada')">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </span>
                                                                            <span >
                                                                                <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Cancelar" onclick="regresar({{$requisiton->id}}, 'Cancelada')">
                                                                                    <i class="fas fa-minus-square"></i>
                                                                                </button>
                                                                            </span>
                                                                        @endif
                                                                        @break
                                                                    @case(6)
                                                                            @if ($requisiton->role == 13 && (Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                                <span >
                                                                                    <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                        <i class="fas fa-check"></i>
                                                                                    </button>
                                                                                </span>
                                                                            @elseif ($requisiton->role == 13 && (Auth::user()->hasAnyRole('lider ventas') || Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                                <span >
                                                                                    <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                        <i class="fas fa-check"></i>
                                                                                    </button>
                                                                                </span>
                                                                            @endif
                                                                        @break
                                                                    @case(7)
                                                                        @if ($requisiton->id_user == auth()->user()->id || Auth::user()->hasAnyRole('admin'))
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Solicitada')">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </span>
                                                                            <span >
                                                                                <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Cancelar" onclick="regresar({{$requisiton->id}}, 'Cancelada')">
                                                                                    <i class="fas fa-minus-square"></i>
                                                                                </button>
                                                                            </span>
                                                                        @endif
                                                                        @break
                                                                    @case(8)
                                                                        @if ($requisiton->id_user == auth()->user()->id || Auth::user()->hasAnyRole(['admin']))
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Solicitada')">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </span>
                                                                            <span >
                                                                                <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Cancelar" onclick="regresar({{$requisiton->id}}, 'Cancelada')">
                                                                                    <i class="fas fa-minus-square"></i>
                                                                                </button>
                                                                            </span>
                                                                        @endif
                                                                        @break
                                                                    @case(10)
                                                                        @if ($requisiton->id_user == auth()->user()->id || Auth::user()->hasAnyRole('admin'))
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Solicitada')">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </span>
                                                                            <span >
                                                                                <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Cancelar" onclick="regresar({{$requisiton->id}}, 'Cancelada')">
                                                                                    <i class="fas fa-minus-square"></i>
                                                                                </button>
                                                                            </span>
                                                                        @endif
                                                                        @break
                                                                    @case(11)
                                                                        @if ($requisiton->id_user == auth()->user()->id || Auth::user()->hasAnyRole('admin'))
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Solicitada')">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </span>
                                                                            <span >
                                                                                <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Cancelar" onclick="regresar({{$requisiton->id}}, 'Cancelada')">
                                                                                    <i class="fas fa-minus-square"></i>
                                                                                </button>
                                                                            </span>
                                                                        @endif
                                                                        @break
                                                                    @case(13)
                                                                        @if ($requisiton->id_user == auth()->user()->id || Auth::user()->hasAnyRole('admin'))
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Solicitada')">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </span>
                                                                            <span >
                                                                                <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Cancelar" onclick="regresar({{$requisiton->id}}, 'Cancelada')">
                                                                                    <i class="fas fa-minus-square"></i>
                                                                                </button>
                                                                            </span>
                                                                        @endif
                                                                        @break
                                                                    @default
                                                                @endswitch
                                                            @break
                                                        @case("Solicitada")
                                                            @switch($requisiton->id_area)
                                                                @case(1)

                                                                        @if (($requisiton->role == 14 || $requisiton->name_role == 'coordinador comercial' ) && (Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="aprobar({{$requisiton->id}}, 'Creada')">
                                                                                    <i class="fas fa-reply"></i>
                                                                                </button>
                                                                            </span>
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </span>

                                                                        @elseif ($requisiton->role != 14 && (Auth::user()->hasAnyRole('coordinador comercial') || Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                            <span>
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="aprobar({{$requisiton->id}}, 'Creada')">
                                                                                    <i class="fas fa-reply"></i>
                                                                                </button>
                                                                            </span>
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </span>
                                                                        @endif
                                                                    @break
                                                                @case(2)
                                                                    @if ($requisiton->id_user == 17 && (Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                        <span >
                                                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="aprobar({{$requisiton->id}}, 'Creada')">
                                                                                <i class="fas fa-reply"></i>
                                                                            </button>
                                                                        </span>
                                                                        <span >
                                                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>
                                                                        </span>
                                                                    @elseif (($requisiton->role == 17 || $requisiton->name_role == 'coordinador de calidad' ) && (Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                        <span >
                                                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="aprobar({{$requisiton->id}}, 'Creada')">
                                                                                <i class="fas fa-reply"></i>
                                                                            </button>
                                                                        </span>
                                                                        <span >
                                                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>
                                                                        </span>

                                                                    @elseif ($requisiton->role != 17 && (Auth::user()->hasAnyRole('coordinador de calidad') || Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                        <span>
                                                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="aprobar({{$requisiton->id}}, 'Creada')">
                                                                                <i class="fas fa-reply"></i>
                                                                            </button>
                                                                        </span>
                                                                        <span >
                                                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>
                                                                        </span>
                                                                    @endif
                                                                    @break
                                                                @case(3)
                                                                        @if ($requisiton->role == 10 && (Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </span>
                                                                        @elseif ($requisiton->role != 10 && (Auth::user()->hasAnyRole('lider compras') || Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </span>
                                                                        @endif
                                                                    @break
                                                                @case(4)
                                                                    @if ($requisiton->role == 15 && (Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                        <span >
                                                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>
                                                                        </span>
                                                                    @elseif ($requisiton->role != 15 && (Auth::user()->hasAnyRole('lider compras') || Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                        <span >
                                                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>
                                                                        </span>
                                                                    @endif
                                                                    @break
                                                                @case(5)
                                                                        @if ($requisiton->role == 11 && (Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </span>
                                                                        @elseif ($requisiton->role != 11 && (Auth::user()->hasAnyRole('lider recursos humanos') || Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </span>
                                                                        @endif
                                                                    @break
                                                                @case(6)
                                                                        @if ($requisiton->role == 13 && (Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </span>
                                                                        @elseif ($requisiton->role == 13 && (Auth::user()->hasAnyRole('lider ventas') || Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </span>
                                                                        @endif
                                                                    @break
                                                                @case(7)
                                                                        @if ($requisiton->role == 14 && (Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </span>
                                                                        @elseif ($requisiton->role != 14 && (Auth::user()->hasAnyRole('lider servicio') || Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </span>
                                                                        @endif
                                                                    @break
                                                                @case(8)

                                                                    @if (($requisiton->role == 15 || $requisiton->name_role == 'coordinador comercial' ) && (Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                        <span >
                                                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="aprobar({{$requisiton->id}}, 'Creada')">
                                                                                <i class="fas fa-reply"></i>
                                                                            </button>
                                                                        </span>
                                                                        <span >
                                                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>
                                                                        </span>

                                                                    @elseif ($requisiton->role != 15 && (Auth::user()->hasAnyRole('coordinador comercial') || Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                        <span>
                                                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="aprobar({{$requisiton->id}}, 'Creada')">
                                                                                <i class="fas fa-reply"></i>
                                                                            </button>
                                                                        </span>
                                                                        <span >
                                                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>
                                                                        </span>
                                                                    @endif
                                                                    @break
                                                                @case(10)
                                                                    @if (($requisiton->role == 14 || $requisiton->name_role == 'coordinador comercial' ) && (Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                        <span >
                                                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="aprobar({{$requisiton->id}}, 'Creada')">
                                                                                <i class="fas fa-reply"></i>
                                                                            </button>
                                                                        </span>
                                                                        <span >
                                                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>
                                                                        </span>

                                                                    @elseif ($requisiton->role != 14 && (Auth::user()->hasAnyRole('coordinador comercial') || Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                        <span>
                                                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="aprobar({{$requisiton->id}}, 'Creada')">
                                                                                <i class="fas fa-reply"></i>
                                                                            </button>
                                                                        </span>
                                                                        <span >
                                                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>
                                                                        </span>
                                                                    @endif
                                                                    @break
                                                                @case(11)
                                                                    @if ($requisiton->role == 14 && (Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                        <span >
                                                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>
                                                                        </span>
                                                                    @elseif ($requisiton->role != 14 && (Auth::user()->hasAnyRole('lider compras') || Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                        <span >
                                                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>
                                                                        </span>
                                                                    @endif
                                                                @break
                                                                @case(13)

                                                                        @if (($requisiton->role == 15 || $requisiton->name_role == 'coordinador comercial' ) && (Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="aprobar({{$requisiton->id}}, 'Creada')">
                                                                                    <i class="fas fa-reply"></i>
                                                                                </button>
                                                                            </span>
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </span>

                                                                        @elseif ($requisiton->role != 15 && (Auth::user()->hasAnyRole('coordinador comercial') || Auth::user()->hasAnyRole('admin') || Auth::user()->hasAnyRole('direccion')))
                                                                            <span>
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="aprobar({{$requisiton->id}}, 'Creada')">
                                                                                    <i class="fas fa-reply"></i>
                                                                                </button>
                                                                            </span>
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Procesada')">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </span>
                                                                        @endif
                                                                    @break
                                                                    @default
                                                            @endswitch
                                                        @break
                                                        @case("Procesada")
                                                            @switch($requisiton->id_area)
                                                                @case(1)
                                                                    @if (Auth::user()->hasAnyRole('coordinador comercial'))
                                                                        <span >
                                                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="aprobar({{$requisiton->id}}, 'Creada')">
                                                                                <i class="fas fa-reply"></i>
                                                                            </button>
                                                                        </span>
                                                                    @endif
                                                                    @if (Auth::user()->hasAnyRole('compras') || Auth::user()->hasAnyRole('admin'))
                                                                        <span >
                                                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Cotizada')">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>
                                                                        </span>
                                                                        <span >
                                                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="regresar({{$requisiton->id}}, 'Creada')">
                                                                                <i class="fas fa-reply"></i>
                                                                            </button>
                                                                        </span>
                                                                    @endif
                                                                @break
                                                                @case(2)

                                                                    @break
                                                                @default
                                                                        @if (Auth::user()->hasAnyRole('coordinador comercial'))
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="aprobar({{$requisiton->id}}, 'Creada')">
                                                                                    <i class="fas fa-reply"></i>
                                                                                </button>
                                                                            </span>
                                                                        @endif
                                                                        @if (Auth::user()->hasAnyRole('compras') || Auth::user()->hasAnyRole('admin'))
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Cotizada')">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </span>
                                                                            <span >
                                                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="regresar({{$requisiton->id}}, 'Creada')">
                                                                                    <i class="fas fa-reply"></i>
                                                                                </button>
                                                                            </span>
                                                                        @endif
                                                                    @break

                                                            @endswitch

                                                        @break
                                                        @case("Cotizada Parcial")
                                                            @if (Auth::user()->hasAnyRole('direccion'))
                                                                <span>
                                                                    <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Aprobada Parcial')">
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                </span>
                                                            @endif
                                                            @break
                                                        @case("Cotizada")
                                                                @if (Auth::user()->hasAnyRole('direccion'))
                                                                    <span>
                                                                        <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Aprobada')">
                                                                            <i class="fas fa-check"></i>
                                                                        </button>
                                                                    </span>
                                                                    <span >
                                                                        <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="regresar({{$requisiton->id}}, 'Procesada')">
                                                                            <i class="fas fa-reply"></i>
                                                                        </button>
                                                                    </span>
                                                                @endif
                                                            @break
                                                        @case("Aprobada Parcial")
                                                        @break
                                                        @case("Aprobada")
                                                                @if (Auth::user()->hasAnyRole('finanzas'))
                                                                    @if ($requisiton->factura == true)
                                                                        <span >
                                                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Pagada" onclick="aprobar({{$requisiton->id}}, 'Pagada')">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>
                                                                        </span>
                                                                    @endif
                                                                    <span >
                                                                        <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="regresar({{$requisiton->id}}, 'Cotizada')">
                                                                            <i class="fas fa-reply"></i>
                                                                        </button>
                                                                    </span>
                                                                @endif
                                                            @break
                                                        @case("Pagada")
                                                            @if (Auth::user()->hasAnyRole('lider compras') || Auth::user()->hasAnyRole('compras') )
                                                                <!-- <span >
                                                                    <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Entregar" onclick="aprobar({{$requisiton->id}}, 'Entregada')">
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                </span> -->
                                                            @endif
                                                        @break
                                                        @case("Entregada")
                                                                @if (Auth::user()->hasAnyRole('lider compras') || Auth::user()->hasAnyRole('compras') || Auth::user()->hasAnyRole('admin'))

                                                                @endif
                                                            @break
                                                        @case("Entregada Parcial")

                                                            @break
                                                        @case("Devolución")
                                                            @if (Auth::user()->hasAnyRole('lider compras') || Auth::user()->hasAnyRole('compras') || Auth::user()->hasAnyRole('admin'))
                                                                <span >
                                                                    <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Aprobar" onclick="aprobar({{$requisiton->id}}, 'Aprobada')">
                                                                        <i class="fas fa-reply"></i>
                                                                    </button>
                                                                </span>
                                                            @endif
                                                        @break
                                                    @endswitch
                                                @endif

                                            </td>
                                        @else
                                            <td></td>
                                        @endif


                                    </tr>
                                @endforeach
                            @endisset

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Area</th>
                                <th>Proyecto</th>
                                <th>Fecha</th>
                                <th>Estatus</th>
                                <th>Acción</th>
                            </tr>
                        </tfoot>
                    </table>
                    <table id="tableRequisitionsCanceladas"  class="table table-striped table-bordered" style="width:100%;display:none;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Area</th>
                                <th>Proyecto</th>
                                <th>Fecha</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Area</th>
                                <th>Proyecto</th>
                                <th>Fecha</th>
                                <th>Accion</th>
                            </tr>
                        </tfoot>
                    </table>


                </div>
            </div>
        </div>
    </div>


@stop

@section('js')
    <script>
        $(document).ready(function() {

            $("#tableRequisitions").DataTable({
                dom: 'Bfrtip',
                //order:[[2,"desc"]],
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
                responsive: {
                    details: {
                        type: 'column',
                        target: -1
                    }
                },
                columnDefs: [
                    {
                        className: 'control',
                        orderable: false,
                        targets:   -1
                    },

                ]
            });



        } );

    </script>
    <script src="{{ asset('vendor/myjs/requisitions.js') }}"></script>

@stop
