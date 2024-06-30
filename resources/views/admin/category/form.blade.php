@extends('vendor.adminlte.page')

@section('title', __('category.label-edit'))

@section('content_header')
    <h1>{{$row->name ?? __('category.title-new')}}</h1>

@stop

@section('content')
    <form action="{{route('admin.category.create')}}" method="post">

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
                <input type="hidden" name="id" value="{{$row->id??''}}">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= __('category.label-edit') ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        @if(!empty($parents))
                            <div class="form-group">
                                <label for=""><?= __('category.parent') ?></label>
                                <select name="parent_id" id="parent_id" class="form-control require" required>
                                    <option value=""><?= __('category.select') ?></option>
                                    @foreach($parents as $key=>$category)
                                        <option value="{{$category->id}}"
                                                @if(isset($row)  && $row->parent_id === $category->id) selected="selected" @endif>
                                            {{$category->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for=""><?= __('category.label-name') ?></label>
                            <input type="hidden" name="level" value="{{$row->level ?? 1}}">
                            <input type="text"
                                   name="name"
                                   value="{{$row->name??''}}"
                                   class="form-control"
                                   required
                                   placeholder="<?=__('category.placeholder-name')?>">
                        </div>

                        @if(isset($childrens))
                            <div class="form-group">
                                <label for=""><?= __('category.children') ?></label>
                                <table  class="table table-striped table-valign-middle">
                                  <tr>
                                      <td>
                                          <input type="text"
                                                 maxlength="100"
                                                 name="subcategory[]"
                                                 class="form-control"
                                                 placeholder="{{__('category.placeholder-name')}}"
                                                 value="">
                                      </td>
                                      <td class="submmenu-link">
                                          <a href="javascript:void(0)"
                                             data-toggle="tooltip"
                                             class="js-new-row"
                                             title="{{__('category.label-title')}}"
                                          >
                                              <i class="fas fa-plus"></i>
                                          </a>
                                          <a href="javascript:void(0)"
                                             data-toggle="tooltip"
                                             class="js-remove-row hidden"
                                             title="{{__('category.label-title-delete')}}"
                                          >
                                              <i class="fas fa-trash"></i>
                                          </a>
                                      </td>
                                  </tr>
                            @foreach($childrens as $children)
                                  <tr>
                                   <td>{{$children->name}}</td>
                                   <td class="submmenu-link">
                                       <a class=" js-confirm"
                                          data-title="{{__('course.message-warning-delete')}}"
                                          data-text="{{__('category.message-message-delete',['category' => $row->name])}}"
                                          href="{{route('admin.category.delete',['category_id' => (int)$children->id])}}">
                                           <i class="fas fa-trash"></i>
                                       </a>

                                   </td>
                                  </tr>
                            @endforeach
                                </table>
                            </div>
                        @endif

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
    <link rel="stylesheet" href="{{ URL::asset('css/extra.css')}}">
@stop

@section('js')
    <script src="{{ asset('js/plugins/summernote/summernote-bs4.js')}}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        $(function () {
            // Summernote
            $('#description').summernote()
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@stop