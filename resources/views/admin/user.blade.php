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
                            <th>Grupo</th>
                            <th>Emails</th>
                            <th>Genero</th>
                            <th>Dirección</th>
                            <th>Escuela</th>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    {{trim($user->name)}}<br>
                                    <span class="badge text-bg-primary">Nombre:{{$user->fullname}}</span>
                                </td>
                                <td>
                                    {{\App\Helpers\LabelsHelper::roleLabel($user->role)}}
                                </td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->gender}}</td>
                                <td>
                                   {{$user->city_name}}<br>
                                    <span class="product-description">{{$user->address}}</span>
                                </td>
                                <td>
                                   {{$user->school_name}}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default">Más</button>
                                        <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu" style="">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Separated link</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

            {{$users->links()}}
        </div>
@stop

@section('css')

@stop

@section('js')

@stop