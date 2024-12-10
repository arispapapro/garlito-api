<?php

// Models
use App\Models\Role;
use App\Models\Language;
// Utilities
use App\Configuration\GarlitoApiConfiguration;

$roles = Role::all();
$languages = Language::all();

$role_options = [];
$language_options = [];

foreach($roles as $role){
    $role_options[] = ['label' => $role->label , 'value' => $role->id];
}

foreach($languages as $language){
    $language_options[] = ['label' => $language->name , 'value' => $language->id ];
}

?>
    <!-- Extend to default authentication layout -->
@extends('garlito.layouts.admin')


<!-- Set Page Title -->
@section('title', $user->first_name . ' ' . $user->last_name )


@section('main-content')

    @if(isset($type) && $type == 'successful_edit')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{__('user.edit.success_message')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <div class="card">
        <div class="card-header">
            <!-- Page Header -->
            <section class="garlito-card-header d-flex align-items-center justify-content-between ">
                <div>
                    <h1>
                        @if(isset($user->first_name) && isset($user->last_name))
                            {{ $user->first_name . ' ' . $user->last_name }}
                        @else
                            User
                        @endif
                    </h1>
                </div>
                <div>
                    #{{$user->id}}
                </div>
            </section>
        </div>
        <form class="garlito-form"  method="POST" action="{{url('user/'. $user->id )}}">
        <div class="card-body">

                <input type="hidden" name="_method" value="PUT">

                @csrf

                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-xl-6 col-xxl-6">
                        <div class="mb-3">
                            <label for="first_name_{{$user->id}}" class="form-label">{{__('user.edit.form.first_name.label')}}</label>
                            <input
                                type="text"
                                class="form-control"
                                id="first_name_{{$user->id}}"
                                name="first_name"
                                value="{{$user->first_name ?? ''}}"
                                required
                                placeholder="{{__('user.edit.form.first_name.placeholder')}}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-xl-6 col-xxl-6">
                        <div class="mb-3">
                            <label for="last_name_{{$user->id}}" class="form-label">{{__('user.edit.form.last_name.label')}}</label>
                            <input
                                type="text"
                                class="form-control"
                                id="last_name_{{$user->id}}"
                                name="last_name"
                                value="{{$user->last_name ?? ''}}"
                                required
                                placeholder="{{__('user.edit.form.last_name.placeholder')}}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-xl-6 col-xxl-6">
                        <div class="mb-3">
                            <label for="email_{{$user->id}}" class="form-label">{{__('user.edit.form.email.label')}}</label>
                            <input
                                autocomplete="email"
                                type="email"
                                class="form-control"
                                id="email_{{$user->id}}"
                                name="email"
                                value="{{$user->email ?? ''}}"
                                required
                                placeholder="{{__('user.edit.form.email.placeholder')}}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-xl-6 col-xxl-6">
                        <div class="mb-3">

                            <label for="edit_user_role_id{{$user->id}}" class="form-label">{{__('user.edit.form.role.label')}}</label>
                            <select id="edit_user_role_id{{$user->id}}" required name="role_id" class="form-select" aria-label="{{__('user.edit.form.role.placeholder')}}">

                                @foreach($role_options as $option)
                                    <option value="{{$option['value']}}" {{ $user->role->id == $option['value'] ? 'selected' : ''}}>{{$option['label']}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-12 col-sm-12 col-md-12 col-xl-6 col-xxl-6">
                        <div class="mb-3">
                            <label for="edit_user_language_id{{$user->id}}" class="form-label">{{__('user.edit.form.language.label')}}</label>
                            <select id="edit_user_language_id{{$user->id}}" required name="language_id"  class="form-select" aria-label="{{__('user.edit.form.language.placeholder')}}">
                                @foreach($language_options as $option)
                                    <option value="{{$option['value']}}" {{ $user->language->id == $option['value'] ? 'selected' : '' }} >{{$option['label']}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>

        </div>

        <div class="card-footer d-flex align-items-center justify-content-end">
            <button type="submit" class="btn btn-primary">{{__('buttons.edit')}}</button>
        </div>
        </form>
    </div>



@endsection

