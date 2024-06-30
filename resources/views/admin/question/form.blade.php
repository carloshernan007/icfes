@extends('vendor.adminlte.page')

@section('title', isset($row->id) ? __('question.title-edit') : __('question.title-new'))

@section('content_header')
    <h1>{{ isset($row->id) ? __('question.title-edit') : __('question.title-new')}}</h1>

@stop

@section('content')
    <form id="form-question" action="{{route('admin.question.create')}}" method="post">
        <input type="hidden" name="id" value="{{$row->id??''}}">
        @csrf

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
            <div class="col-lg-8 col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{__('question.general')}}</small></h3>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label>{{__('question.description')}}</label>
                            <textarea name="description" id="description" required>{{$row->description??''}}</textarea>
                        </div>

                        <hr>
                        <h2>{{__('question.options')}}</h2>
                        <p>{{__('question.message-options')}}</p>
                        <div class="option-content">
                        <div class="row element">
                            <div class="col-lg-10 col-md-10">
                                <div class="form-group">
                                    <label>{{__('question.option-label')}}</label>

                                    <textarea class="description" name="option[0][description]" ></textarea>
                                    <div class="icheck-success d-inline" >
                                        <input class="input-answer"  id="radioDanger_0" type="radio" value="0" name="answer" required>
                                        <label class="label-answer" for="radioDanger_0">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2">
                                <span class="info-box-icon bg-info btn-question-plus js-new-element">
                                    <i class="fas fa-plus"></i>
                                </span>
                            </div>
                        </div>


                        @if(isset($options))
                            @foreach($options as $option)
                                <div class="row">
                                    <div class="col-lg-10 col-md-10">
                                        <div class="form-group">
                                            <label>{{__('question.option-label')}}</label>

                                            <textarea class="description" name="option[{{$option->id}}][description]" >{{$option->description}}</textarea>
                                            <div class="icheck-success d-inline" >
                                                <input  id="radioDanger{{$option->id}}" type="radio" value="{{$option->id}}" name="answer" @if($option->point > 0) checked @endif required>
                                                <label for="radioDanger{{$option->id}}">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        </div>

                        <div class="col-md-12 col-sm-12 col-12 text-center">
                            <button type="submit"
                                    class="btn btn-primary js-submit ">
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
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{__('question.attributo')}}</h3>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label>{{__('course.courses')}}</label>
                            <select class="form-control"  name="course[]" required multiple>
                                @foreach($courses as $course)
                                    <option value="{{$course->id}}" @if(isset($activeCourse) && in_array($course->id,$activeCourse)) selected @endif>
                                        {{$course->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>{{__('category.title')}}</label>
                            <select class="form-control  js-ajax"
                                    name="category"
                                    data-child="subcategory_id"
                                    data-url="{{url('/category')}}/"
                                    required>
                                <option value=""><?= __('users.label-select') ?></option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" @if(isset($categoryParentId) && $category->id == $categoryParentId) selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>{{__('category.title')}}</label>
                            <select class="form-control"
                                    name="subcategory[]"
                                    id="subcategory_id"
                                    required
                                    multiple
                                @foreach($subCategories as $category)
                                    <option value="{{$category->id}}" @if(in_array($category->id,$activeCategory)) selected @endif>{{$category->name}}</option>
                                @endforeach

                            </select>
                        </div>
                        @php
                            if(isset($row)){
                                $goodTotal = $total= $row->good_answers + $row->bad_answers;
                                if($total > 0){
                                   $goodTotal = number_format(($row->good_answers/$total) * 100,2);
                                }
                            }else{
                                $total = 0;
                            }
                        @endphp

                    </div>
                </div>

                @if($total > 0)
                    <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{__('question.label-good')}}</span>
                            <span class="info-box-number">{{$row->good_answers}}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: {{$goodTotal}}%"></div>
                            </div>
                            <span class="progress-description">
      {{__('question.message-good-answer',['answer' => $goodTotal])}}
    </span>
                        </div>
                    </div>
                @endif
            </div>
        </div>



    </form>

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('js/plugins/summernote/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('css/extra.css')}}">
@stop

@section('js')
    <script src="{{ asset('js/plugins/summernote/summernote-bs4.js')}}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        $(function () {

            $('#form-question').on('submit',function (e){

                let options = $('.option-content .description').length;
                if(options < 2){
                    Swal.fire({
                        title: "<?=__('general.title')?>",
                        text: "<?=__('question.message-recomentation')?>",
                        icon: "error"
                    });
                    e.preventDefault();
                }
                return true;
            });


            // Summernote
            $('.description').summernote();

            $('#description').summernote({
                height: 300,
                callbacks: {
                    onImageUpload: function(files) {
                        validateAndUploadImage(files[0]);
                    }
                }}
            )

            function validateAndUploadImage(file) {
                var maxFileSize = 500 * 1024; // 500 KB
                if (file.size > maxFileSize) {
                    alert('La imagen supera el tamaño máximo permitido de 500 KB.');
                    return;
                }
                uploadImage(file);
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            function uploadImage(file) {
                var data = new FormData();
                data.append('file', file);
                $.ajax({
                    url: '{{ route("admin.question.image") }}',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: data,
                    type: 'POST',
                    success: function(url) {
                        if(url.error == '' ) {
                            var image = $('<img>').attr('src', url.url);
                            $('#description').summernote('insertNode', image[0]);
                        }
                    },
                    error: function(data) {
                        console.error("Error al subir la imagen");
                    }
                });
            }

            $('[data-toggle="tooltip"]').tooltip();

            $('.js-new-element').on('click',function(e){
                let row =  $(this).parents('.element');
                let clone = row.clone();
                const timestampUnix = Date.now() / 1000;
                clone.find('.note-editor').remove();
                clone.find('.description')
                    .val('')
                    .attr('name','option['+timestampUnix+'][description]')
                    .summernote('destroy');
                clone.find('.description').summernote();
                clone.find('.input-answer')
                    .attr('id','radioDanger_' + timestampUnix)
                    .val(timestampUnix);
                clone.find('.label-answer').attr('for','radioDanger_' + timestampUnix);
                clone.find('.js-new-element').addClass('bg-danger js-remove-element').removeClass('bg-info').removeClass('js-new-element')
                clone.find('.fa-plus').addClass('fa-trash').removeClass('fa-plus')
                row.after(clone)
            });
        })
    </script>
@stop