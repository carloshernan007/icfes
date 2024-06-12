@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1><?=__('users.title-list-user')?></h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title"><?=__('users.title-list-user')?></h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-tool btn-sm">
                            <i class="fas fa-download"></i>
                        </a>
                        <a href="{{route('admin.user.create')}}"
                           class="btn btn-tool btn-sm"
                           data-toggle="tooltip"
                           data-placement="top"
                           title="<?=__('users.title-user')?>">
                            <i class="fas fa-user"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                        <tr>
                            <th><?=__('users.label-id')?></th>
                            <th><?=__('users.label-user')?></th>
                            <th><?=__('users.label-group')?></th>
                            <th><?=__('users.label-email')?></th>
                            <th><?=__('users.label-gender')?></th>
                            <th><?=__('users.label-address')?></th>
                            <th><?=__('users.label-school')?></th>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->user_id}}</td>
                                <td>
                                    {{trim($user->name)}}<br>
                                    <span class="badge text-bg-primary">Nombre:{{$user->fullname}}</span><br>
                                    <small class="badge badge-danger"><i class="far fa-clock"></i> {{$user->created}}</small>
                                </td>
                                <td>{{\App\Helpers\LabelsHelper::roleLabel($user->role)}}
                                </td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->gender}}</td>
                                <td>
                                   {{$user->city_name}}<br>
                                    <span class="product-description">{{$user->address}}</span>
                                </td>
                                <td>
                                   {{$user->school_name}}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default">Más</button>
                                        <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu" style="">
                                            <a class="dropdown-item"
                                               href="{{route('admin.user.edit',['user_id' => (int)$user->user_id])}}">
                                                <?=__('users.label-edit')?>
                                            </a>
                                            @if($user->role == 4)
                                                <a class="dropdown-item"
                                                   href="{{route('admin.user.edit',['user_id' => (int)$user->user_id])}}"
                                                >
                                                    <?=__('users.label-report')?>
                                                </a>
                                            @endif

                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

            {{$users->links()}}
        </div>
@stop

@section('css')

@stop

@section('js')

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

@stop