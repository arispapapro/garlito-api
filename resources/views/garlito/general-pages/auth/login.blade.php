<!-- Extend to default authentication layout -->
@extends('garlito.layouts.auth')


<!-- Set Page Title -->
@section('title', 'Login')


@section('form')

    <form class="col-10 col-sm-8 col-md-7 col-lg-7 col-xl-8 col-xxl-7" method="POST" action="{{url('login')}}">

        <div class="d-flex align-items-center justify-content-center mb-4">
            <img class="auth-logo" src="{{asset('images/branding/logo.png')}}" alt="Logo">
        </div>

        <!-- CSRF Protection -->
        @csrf

        <!-- Equivalent to... -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

        @if ($errors->has('login_error'))
            <div class="alert alert-danger text-center" role="alert">
                {{ $errors->first('login_error') }}
            </div>
        @endif

        <div class="mb-3">
            <label for="email" class="form-label">{{__('auth.login.form.email.label')}}</label>
            <input
                type="email"
                name="email"
                class="form-control"
                autocomplete="off"
                placeholder="{{__('auth.login.form.email.placeholder')}}"
                id="email" >
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">{{__('auth.login.form.password.label')}}</label>
            <input
                type="password"
                name="password"
                class="form-control"
                autocomplete="new-password"
                placeholder="{{__('auth.login.form.password.placeholder')}}"
                id="password" >
        </div>

        <div class="d-flex align-items-center justify-content-center">
            <button type="submit" class="btn btn-primary">{{__('auth.login.form.button')}}</button>
        </div>

    </form>
@endsection
