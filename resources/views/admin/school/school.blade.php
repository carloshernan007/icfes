@extends('adminlte::page')

@section('title', __('school.schools'))

@section('content_header')
    <h1><?=__('school.schools')?></h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title"><?=__('school.school')?></h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-tool btn-sm">
                            <i class="fas fa-download"></i>
                        </a>
                        <a href="{{route('admin.user.create')}}"
                           class="btn btn-tool btn-sm"
                           data-toggle="tooltip"
                           data-placement="top"
                           title="<?=__('school.label-new')?>">
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
                            <th style="max-width: 450px"><?=__('school.label-description')?></th>
                            <th><?=__('school.label-address')?></th>
                            <th><?=__('school.label-created')?></th>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($rows as $row)
                                <td>{{$row->id}}</td>
                                <td>
                                    {{$row->school_name}}
                                </td>
                                <td style="max-width: 450px">{{$row->school_description}}</td>
                                <td>
                                    <span class="product-description">{{$row->school_address}}</span>
                                    {{$row->city_name}}
                                </td>
                                <td>{{$row->created}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default">Más</button>
                                        <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu" style="">
                                            <a class="dropdown-item"
                                               href="{{route('admin.user.edit',['user_id' => (int)$row->school_id])}}">
                                                    <?=__('users.label-edit')?>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>


        </div>
@stop

@section('css')
       <link rel="stylesheet" href="{{ URL::asset('css/extra.css')}}">
 @stop

@section('js')

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

@stop