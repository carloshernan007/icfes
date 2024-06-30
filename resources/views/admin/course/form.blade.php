@extends('vendor.adminlte.page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{$user->name ?? __('course.title-new')}}</h1>

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
                <input type="hidden" name="id" value="{{$course->id??''}}">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= __('course.course') ?></h3>
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
                                   required
                                   placeholder="<?=__('course.placeholder-name')?>">
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