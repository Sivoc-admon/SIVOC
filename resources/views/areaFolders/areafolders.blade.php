@extends('adminlte::page')

@section('title', 'SIVOC-USUARIOS')

@section ( ' plugins.Datatables ' , true)

@section('content_header')
    <h1 class="m-0 text-dark">Usuarios</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalRegisterUser">
                        Nuevo Usuario
                    </button>
                    @include('users.register')

                   
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form>
                        <select class="form-control">
                            <option value="{{$datos->nivel}}">{{$datos->folder}}</option>
                          </select>
                    </form>
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
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Fecha</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                           <td></td>
                            
                            
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nombre</th>
                                <th>fecha</th>
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
            $('#tableDocuments').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel', 'pdf'
                ]
            });
        } );
</script>
@stop
