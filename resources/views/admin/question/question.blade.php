@extends('vendor.adminlte.page')

@section('title', __('question.title'))

@section('content_header')
    <h1><?=__('question.title')?></h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title"><?=__('question.subtitle')?></h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-tool btn-sm">
                            <i class="fas fa-download"></i>
                        </a>
                        <a href="{{route('admin.question.create')}}"
                           class="btn btn-tool btn-sm"
                           data-toggle="tooltip"
                           data-placement="top"
                           title="<?=__('question.label-new')?>">
                            <i class="fas fa-user"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                        <tr>
                            <th><?=__('users.label-id')?></th>
                            <th><?=__('question.description')?></th>
                            <th class="text-center"><?=__('question.courses')?></th>
                            <th class="text-center"><?=__('question.label-status')?></th>
                            <th class="text-right"><?=__('school.label-created')?></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($rows as $row)
                              <tr>
                                <td>{{$row->question_id}}</td>
                                <td style="width: 50%">
                                    @php
                                        $description= strip_tags($row->description);
                                    @endphp
                                    <div>{{Str::limit($description, 300, '...') }}</div>
                                    <small class="badge badge-info">
                                        <i class="far fa-user"></i> {{$row->name}}
                                    </small>

                                    <small class="badge badge-warning">
                                        <i class="fa fa-tags"></i> {{$row->category}}
                                    </small>


                                </td>
                                <td class="text-center">{{$row->course_count}}</td>
                                <td class="text-center">

                                    <a href="{{route('admin.question.status',['question_id' => (int)$row->question_id])}}"
                                       class="js-status"
                                    >
                                        {{ $row->status? __('question.label-enable'): __('question.label-disable') }}
                                    </a>

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
                                               href="{{route('admin.question.edit',['question_id' => (int)$row->question_id])}}">
                                                    <?=__('users.label-edit')?>
                                            </a>

                                            <a class="dropdown-item js-confirm"
                                               data-title="{{__('question.message-warning-delete')}}"
                                               data-text="{{__('question.message-message-delete',['question' => Str::limit($description, 300, '...') ])}}"
                                               href="{{route('admin.question.delete',['question_id' => (int)$row->question_id])}}">
                                                    <?=__('users.label-delete')?>
                                            </a>

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