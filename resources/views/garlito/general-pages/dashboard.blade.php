<!-- Extend to default authentication layout -->
@extends('garlito.layouts.admin')


<!-- Set Page Title -->
@section('title', 'Dashboard')


@section('main-content')

    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 col-xl-3 col-xxl-3 g-mb-15">
            @include('garlito.components.dashboard.total-notifications-card')
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-xl-3 col-xxl-3 g-mb-15">
            @include('garlito.components.dashboard.total-users-card')
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-xl-3 col-xxl-3 g-mb-15">
            @include('garlito.components.dashboard.total-roles-card')
        </div>
    </div>
@endsection


