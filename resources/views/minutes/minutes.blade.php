@extends('adminlte::page')

@section('title', 'SIVOC-MINUTAS')

@section('content_header')
    <link rel="stylesheet" href="{{ asset("vendor/mycss/style.css") }}">
    <h1 class="m-0 text-dark">MINUTAS</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(Auth::user()->hasAnyRole(['admin', 'calidad', 'operaciones', 'manufactura', 'servicio']))
                    <span data-toggle="modal" data-target="#ModalRegisterMinute">
                        <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Nueva Minuta">
                            <i class="fas fa-plus"></i>
                        </button>
                    </span>
                   
                    @endif
                    @include('minutes.register_minute')
                    @include('minutes.register_agreement')
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="tableMinutes" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Minuta</th>
                                <th>Participantes</th>
                                <th>Participantes Externos</th>
                                <th>Estatus</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($minutes)
                                @foreach ($minutes as $minute)
                                    <tr>
                                        <td>{{ $minute->id }}</td>
                                        <td>{{ $minute->description }}</td>
                                        <td>{{ $minute->participant }}</td>
                                        <td>{{ $minute->external_participant }}</td>
                                        <td>{{ $minute->status }}</td>
                                        
                                        <td>
                                            <span data-toggle="modal" data-target="#ModalRegisterAgreement">
                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Nuevo acuerdo" onclick="datosMinute({{$minute->id}})">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </span>
                                            <span data-toggle="modal" data-target="#ModalShowAgreement">
                                                <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Mostrar acuerdos" onclick="showAgreement({{$minute->id}})">
                                                    <i class="fas fa-list"></i>
                                                </button>
                                            </span>
                                            <span data-toggle="modal" data-target="#ModalShowFiles">
                                                <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Mostrar archivos" onclick="showMinuteFile({{$minute->id}})">
                                                    <i class="fas fa-list"></i>
                                                </button>
                                            </span>
                                            <a class="btn btn-primary" href="{{ route('minutes.edit',$minute->id) }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset
                            
                            
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Minuta</th>
                                <th>Participantes</th>
                                <th>Participantes Externos</th>
                                <th>Estatus</th>
                                <th>Accion</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- GRAFICA DE MINUTAS
    <div class="row">
        <div class="col-md6">
            <div class="card card-danger">
                <div class="card-header">
                  <h3 class="card-title">Estatus de Proyecto</h3>
  
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                  <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 348px;" width="435" height="312" class="chartjs-render-monitor"></canvas>
                </div>
                
              </div>
        </div>
    </div> -->
@stop

@section('js')
    <script>
        $(document).ready(function() {
            let statusGrafica="";

            $("#tableMinutes").DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
                responsive: {
                    details: {
                        type: 'column',
                        target: -1
                    }
                },
                columnDefs: [ {
                    className: 'control',
                    orderable: false,
                    targets:   -1
                } ]
            });
            
            //grafica(1,'donutChart', 'pie');
        } );
    </script>
    <script src="{{ asset('vendor/myjs/minutes.js') }}"></script>

@stop
