@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Usuarios</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Últimas evaludaciones</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-tool btn-sm">
                            <i class="fas fa-download"></i>
                        </a>
                        <a href="{{route('admin.user')}}" class="btn btn-tool btn-sm">
                            <i class="fas fa-bars"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Nombre</th>
                                <th>Grupo</th>
                                <th>Emails</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            @endforeach
                        </tbody>
                    </table>

                    {{$user->links()}}
                </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop