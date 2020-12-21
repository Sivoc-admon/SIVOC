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
                                    <td><button type="button" class="btn btn-success">Editar</button></td>
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
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#tableProjects').DataTable({
                /*dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]*/
            });
        } );
</script>
@stop
