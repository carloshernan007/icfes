@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{$user->name ?? 'Nuevo usuario'}}</h1>

@stop

@section('content')
    <div class="row">
        <div class="col-md-6 col-sm-12 col-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Cuenta</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="usuario">Usuario</label>
                            <input type="name"
                                   class="form-control require"
                                   placeholder="Ingrese un nombre de usuario"
                                   value="{{$user->name}}"
                            >
                        </div>
                        <div class="form-group">
                            <label for="email">Correo electronico</label>
                            <input type="email"
                                   class="form-control require"
                                   placeholder="Ingrese un correo eléctronico"
                                   value="{{$user->email}}"
                            >
                        </div>
                        <div class="form-group">
                            <label for="email">Grupo</label>
                            <select name="role" id="role"   class="form-control require">
                                <option value="">Por favor seleccione</option>
                                @foreach($roles as $key=>$row)
                                    <option value="{{$key}}" @if($key === $user->role) selected="selected" @endif>{{$row}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Registrado</label>
                            <input type="text"
                                   readonly
                                   class="form-control"
                                   value="{{$user->created_at}}"
                            >
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password"
                                   class="form-control"
                                   placeholder="Ingrese una contraseña"
                                   value=""
                            >
                        </div>


                    </div>
            </div>

        </div>
        <div class="col-md-6 col-sm-12 col-6">


            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Información</h3>
                </div>
                <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="usuario">Nombre Completo</label>
                            <input type="fullname"
                                   class="form-control require"
                                   placeholder="Ingrese un nombre de usuario"
                                   value="{{$register->fullname}}"
                            >
                        </div>
                        <div class="form-group">
                            <label for="region">Región</label>
                            <select name="region_id" id="region_id"   class="form-control require">
                                <option value="">Por favor seleccione</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city">Ciudad</label>
                            <select name="city_id" id="city_id"   class="form-control require">
                                <option value="">Por favor seleccione</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="address">Dirección</label>
                            <input type="address"
                                   class="form-control require"
                                   placeholder="Ingrese su dirección"
                                   value="{{$register->address}}"
                            >
                        </div>
                        <div class="form-group">
                            <label for="gender">Genero</label>
                            <select name="gender" id="gender"   class="form-control require">
                                <option value="">Por favor seleccione</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="school">Escuela</label>
                            <select name="school_id" id="school"   class="form-control require">
                                <option value="">Por favor seleccione</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="school">Cursos</label>
                            <select class="form-control " multiple aria-label="multiple select example">
                                <option>Seleccione</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>

                    </div>
                    <!-- /.card-body -->
            </div>
        </div>
    </div>



@stop

@section('css')

@stop

@section('js')
    <script src="{{ asset('js/main.js') }}"></script>
@stop