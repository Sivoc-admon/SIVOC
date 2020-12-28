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
                    <span data-toggle="modal" data-target="#ModalRegisterUser">
                        <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Nuevo Usuario">
                            <i class="fas fa-user-plus"></i>
                        </button>
                    </span>
                    @include('users.register')

                   
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- class="table table-striped table-bordered" -->
                    <table id="tableUsers" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Correo</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->mother_last_name }}</td>
                                    <td>{{ $user->mail }}</td>
                                    <td>
                                        <form action="{{ route('users.destroy',$user->id) }}" method="POST">
                           
                                            <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
                           
                                            @csrf
                                            @method('DELETE')
                              
                                            <button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fas fa-minus-square"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Correo</th>
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
            
            table('tableUsers');
        } );
    </script>  
    <script src="{{ asset('vendor/myjs/users.js') }}"></script> 
@stop

