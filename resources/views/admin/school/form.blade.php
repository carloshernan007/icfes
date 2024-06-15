@extends('vendor.adminlte.page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{$user->name ?? __('school.title-new')}}</h1>

@stop

@section('content')
    <form action="{{route('admin.school.create')}}" method="post">

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
            <div class="col-md-12">
                @csrf
                <input type="hidden" name="id" value="{{$school->id??''}}">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= __('school.school') ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for=""><?= __('school.label-name') ?></label>
                            <input type="text"
                                   name="name"
                                   value="{{$school->name??''}}"
                                   class="form-control"
                                   required
                                   placeholder="<?=__('school.placeholder-name')?>">
                        </div>

                        <div class="form-group">
                            <label for=""><?= __('school.label-address') ?></label>
                            <input type="text"
                                   required
                                   name="address"
                                   value="{{$school->address??''}}"
                                   class="form-control"
                                   placeholder="<?=__('school.placeholder-address')?>">
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
                                    <option value="{{$region->id}}"
                                            @if(isset($regionId) && $region->id == $regionId) selected @endif>
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
                                        <option value="{{$city->id}}"
                                                @if($city->id == $school->city_id) selected @endif>
                                            {{$city->name}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for=""><?= __('school.label-description') ?></label>
                            <textarea
                                    id="description"
                                    name="description"
                                    class="form-control" >{{$school->description??''}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-12 text-center">
                <button type="submit"
                        class="btn btn-primary ">
                    <span class="fas fa-user-plus"></span>
                    <?= __('users.button-save') ?>
                </button>
                <button onclick="history.back()"
                        type="button"
                        class="btn btn-secondary">
                    <span class="fas fa-user"></span>
                    <?= __('users.button-back') ?>
                </button>
            </div>
        </div>

    </form>

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/summernote/summernote-bs4.css')}}">
@stop

@section('js')
    <script src="{{ asset('js/plugins/summernote/summernote-bs4.js')}}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        $(function () {
            // Summernote
            $('#description').summernote()

        })
    </script>
@stop