@extends('vendor.adminlte.page')

@section('title', __('category.title'))

@section('content_header')
    <h1><?=__('category.title')?></h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title"><?=__('category.subtitle')?></h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-tool btn-sm">
                            <i class="fas fa-download"></i>
                        </a>
                        <a href="{{route('admin.category.create')}}"
                           class="btn btn-tool btn-sm"
                           data-toggle="tooltip"
                           data-placement="top"
                           title="<?=__('category.label-new')?>">
                            <i class="fas fa-user"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                        <tr>
                            <th><?=__('users.label-id')?></th>
                            <th><?=__('school.label-name')?></th>
                            <th ><?=__('category.parent')?></th>
                            <th class="text-center" ><?=__('category.level')?></th>
                            <th class="text-right"><?=__('school.label-created')?></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($rows as $row)
                              <tr>
                                <td>{{$row->id}}</td>
                                <td style="width: 50%">{{$row->name}}</td>
                                <td>{{$row->parent_name}}</td>
                                <td class="text-center" >
                                    <span class="badge"
                                          style="background-color: {{\App\Helpers\LabelsHelper::getGetLevelColor($row->level)}}">
                                        {{$row->level}}
                                    </span>
                                </td>
                                <td class="text-right">{{$row->created_at}}</td>
                                <td style="text-align: right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default">Más</button>
                                        <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu" style="">
                                            <a class="dropdown-item"
                                               href="{{route('admin.category.edit',['category_id' => (int)$row->id])}}">
                                                    <?=__('users.label-edit')?>
                                            </a>
                                            @if($row->level != 1)
                                            <a class="dropdown-item js-confirm"
                                               data-title="{{__('category.message-warning-delete')}}"
                                               data-text="{{__('category.message-message-delete',['category' => $row->name])}}"
                                               href="{{route('admin.category.delete',['category_id' => (int)$row->id])}}">
                                                    <?=__('users.label-delete')?>
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{$rows->links()}}
        </div>
@stop

@section('css')
       <link rel="stylesheet" href="{{ URL::asset('css/extra.css')}}">
 @stop

@section('js')
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

@stop