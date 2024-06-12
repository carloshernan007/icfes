@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{$user->name ?? 'Nuevo usuario'}}</h1>

@stop

@section('content')
    <form action="{{route('admin.user.store')}}" method="post">

        <div class="row">
            <div class="col-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-12 col-6">

                @csrf
                <input type="hidden" name="user_id" value="{{$user->id??''}}">
                <input type="hidden" name="register_id" value="{{$register->id??''}}">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= __('users.data-account') ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for=""><?=__('users.label-user')?></label>
                            <input type="text"
                                   name="name"
                                   value="{{$user->name??''}}"
                                   class="form-control"
                                   placeholder="<?=__('users.placeholder-user')?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Correo electronico</label>
                            <label for=""><?=__('users.label-email')?></label>
                            <input type="email"
                                   name="email"
                                   value="{{$user->email??''}}"
                                   class="form-control"
                                   placeholder="<?=__('users.label-email')?>">
                        </div>
                        <div class="form-group">
                            <label for="email"><?=__('users.label-group');?></label>
                            <select name="role" id="role" class="form-control require">
                                <option><?= __('users.label-select') ?></option>
                                @foreach($roles as $key=>$row)
                                    <option value="{{$key}}"
                                            @if(isset($user) && $key === $user->role) selected="selected" @endif>{{$row}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email"><?=__('users.label-created')?></label>
                            <input type="text"
                                   readonly
                                   class="form-control"
                                   value="{{$user->created_at??''}}"
                            >
                        </div>
                        <div class="form-group">
                            <label for=""><?=__('users.label-password')?></label>
                            <input type="password"  name="password" class="form-control" placeholder="{{ __('adminlte::adminlte.password') }}">
                        </div>


                    </div>
                </div>

            </div>
            <div class="col-md-6 col-sm-12 col-6">


                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= __('users.title-personal-information') ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for=""><?=__('users.label-fullname')?></label>
                            <input type="text"
                                   name="fullname"
                                   class="form-control"
                                   placeholder="<?=__('users.label-fullname')?>"
                                   required
                                   value="{{$register->fullname??''}}"
                            >
                        </div>
                        <div class="form-group">
                            <label for=""><?= __('users.label-region') ?></label>
                            <select
                                    class="form-control js-ajax"
                                    id="region_id"
                                    data-child="city_id"
                                    data-url="{{url('/city')}}/"
                                    name="region_id"
                                    required
                            >
                                <option><?= __('users.label-select') ?></option>
                                @foreach($regions as $region)
                                    <option value="{{$region->id}}" @if(isset($regionId) && $region->id == $regionId) selected @endif>
                                        {{$region->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for=""><?= __('users.label-city') ?></label>
                            <select class="form-control" id="city_id" name="city_id" required>
                                <option><?= __('users.label-select') ?></option>
                                @if(isset($cities))
                                    @foreach($cities as $city)
                                        <option value="{{$city->id}}" @if($city->id == $register->city_id) selected @endif>
                                            {{$city->name}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="address"><?= __('users.label-address') ?></label>
                            <input type="text"
                                   name="address"
                                   class="form-control"
                                   required
                                   placeholder="Ingrese su dirección"
                                   value="{{$register->address??''}}"
                            >
                        </div>
                        <div class="form-group">
                            <label for=""><?= __('users.label-gender') ?></label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option><?= __('users.label-select') ?></option>
                                <option value="H" @if(isset($register) && 'H' == $register->gender) selected @endif>
                                    <?= __('users.label-man') ?>
                                </option>
                                <option value="M" @if(isset($register) &&  'M' == $register->gender) selected @endif>
                                    <?= __('users.label-male') ?>
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for=""><?= __('users.label-school') ?></label>
                            <select class="form-control js-ajax"
                                    id="school_id"
                                    data-child="course_id"
                                    data-url="{{url('/course')}}/"
                                    name="school_id"
                                    required
                            >
                                <option><?= __('users.label-select') ?></option>
                                @foreach($schools as $school)
                                    <option value="{{$school->id}}"
                                            @if(isset($register) && $school->id == $register->school_id) selected @endif>
                                        {{$school->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for=""><?= __('users.label-course') ?></label>
                            <select class="form-control" id="course_id" name="courses[]" multiple>
                                <option><?= __('users.label-select') ?></option>
                                @if(isset($courses))
                                    @foreach($courses as $course)
                                        <option value="{{$course->id}}"
                                                @if( in_array($course->id,$courseActive)) selected @endif>
                                            {{$course->name}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-12 text-center">
                <button type="submit"
                        class="btn btn-primary ">
                    <span class="fas fa-user-plus"></span>
                    <?=__('users.button-save')?>
                </button>
                <button onclick="history.back()"
                        type="button"
                        class="btn btn-secondary">
                    <span class="fas fa-user"></span>
                    <?=__('users.button-back')?>
                </button>
            </div>
        </div>
    </form>

@stop

@section('css')

@stop

@section('js')
    <script src="{{ asset('js/main.js') }}"></script>
@stop