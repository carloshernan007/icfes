@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
@endif

@section('auth_body')
    <form action="{{ $register_url }}" method="post">
        @csrf

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h3><?=__('users.data-account')?></h3>
        <p><?=__('users.information-account')?></p>

        <div class="register">
            <div class="form-group">
                <label for=""><?=__('users.label-user')?></label>
                <input type="text"  name="name" class="form-control" placeholder="<?=__('users.placeholder-user')?>">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for=""><?=__('users.label-email')?></label>
                <input type="email" name="email" class="form-control" placeholder="<?=__('users.label-email')?>">
                @error('email')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for=""><?=__('users.label-password')?></label>
                <input type="password"  name="password" class="form-control" placeholder="{{ __('adminlte::adminlte.password') }}">
                @error('password')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for=""><?=__('users.label-password-confirmation')?></label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="<?=('user.placeholder-confirmation')?>">
                @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <h3><?=__('users.title-personal-information')?></h3>
        <p><?=__('users.information-personal')?></p>

        <div class="personal">
            <div class="form-group">
                <label for=""><?=__('users.label-fullname')?></label>
                <input type="text" name="fullname" class="form-control" placeholder="<?=__('users.label-fullname')?>">
                @error('fullname')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for=""><?=__('users.label-gender')?></label>
                <select class="form-control" id="gender"  name="gender">
                    <option ><?=__('users.label-select')?></option>
                    <option value="H"><?=__('users.label-man')?></option>
                    <option value="M"><?=__('users.label-male')?></option>
                </select>
            @error('gender')
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
            </div>
            <div class="form-group">
                <label for=""><?=__('users.label-address')?></label>
                <input type="text"
                       name="address"
                       class="form-control"
                       maxlength="100"
                       placeholder="<?=__('users.label-address')?>">
                @error('address')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for=""><?=__('users.label-school')?></label>
                <select class="form-control js-ajax"
                        id="school_id"
                        data-child="course_id"
                        data-url="{{url('/course')}}/"
                        name="school_id">
                    <option ><?=__('users.label-select')?></option>
                    @foreach($schools as $school)
                        <option value="{{$school->id}}">{{$school->name}}</option>
                    @endforeach
                </select>
                @error('school_id')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for=""><?=__('users.label-region')?></label>
                <select
                        class="form-control js-ajax"
                        id="region_id"
                        data-child="city_id"
                        data-url="{{url('/city')}}/"
                        name="region_id">
                    <option><?=__('users.label-select')?></option>
                    @foreach($regions as $region)
                        <option value="{{$region->id}}">{{$region->name}}</option>
                    @endforeach
                </select>
                @error('region_id')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for=""><?=__('users.label-city')?></label>
                <select class="form-control" id="city_id"  name="city_id">
                    <option><?=__('users.label-select')?></option>

                </select>
                @error('city_id')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for=""><?=__('users.label-course')?></label>
                <select class="form-control" id="course_id"  name="course_id">
                    <option><?=__('users.label-select')?></option>

                </select>
                @error('city_id')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>


        {{-- Register button --}}
        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
            <span class="fas fa-user-plus"></span>
            {{ __('adminlte::adminlte.register') }}
        </button>

    </form>
@stop

@section('auth_footer')
    <p class="my-0">
        <a href="{{ $login_url }}">
            {{ __('adminlte::adminlte.i_already_have_a_membership') }}
        </a>
    </p>
@stop


@section('js')
    <script src="{{ asset('js/main.js') }}"></script>
@stop