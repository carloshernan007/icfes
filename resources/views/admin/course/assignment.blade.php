@extends('vendor.adminlte.page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{__('course.label-assignment')}}</h1>

@stop

@section('content')
    <form action="{{route('admin.course.assignment.save')}}" method="post">

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
                <input type="hidden" name="id" value="{{$course->id??''}}">
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
                                   value="{{$course->name??''}}"
                                   class="form-control"
                                   readonly
                                   placeholder="<?=__('school.placeholder-name')?>">
                        </div>

                        <div class="form-group">
                            <label for=""><?= __('course.label-school') ?></label>
                            <select
                                    class="form-control js-ajax"
                                    id="school_id"
                                    name="school_id[]"
                                    required
                                    multiple
                            >
                                @foreach($schools as $row)
                                    <option value="{{$row->id}}"
                                            @if( in_array($row->id,$schoolActive)) selected @endif>
                                        {{$row->name}}
                                    </option>
                                @endforeach
                            </select>
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