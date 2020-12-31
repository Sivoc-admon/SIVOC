@extends('adminlte::page')

@section('title', 'SIVOC-PROYECTOS')

@section('content_header')
    <h1 class="m-0 text-dark">PROYECTOS</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Nuevo Proyecto
                    </button>
                    @include('projects.register_project')

                    
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="tableProjects" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Proyecto</th>
                                <th>Cliente</th>
                                <th>Estatus</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td>{{ $project->name }}</td>
                                    <td>{{ $project->client }}</td>
                                    <td>{{ $project->status }}</td>
                                    <td><a class="btn btn-primary" href="{{ route('projects.edit',$project->id) }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a></td>
                                </tr>
                            @endforeach
                            
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Proyecto</th>
                                <th>Cliente</th>
                                <th>Estatus</th>
                                <th>Accion</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

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
                <!-- /.card-body -->
              </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            let statusGrafica="";
            /*console.log('{{$projects}}');
            console.log(JSON.parse('{{$projects}}'));*/
            //JSON.parse(text[, reviver]);
            /*for each (var projects in project) {
                console.log('id:'+'{{ $project->id }}', 'estatus:'+'{{ $project->status }}');
            }*/
            
            table('tableProjects');
            grafica(1,'donutChart', 'pie');
        } );
</script>

@stop
