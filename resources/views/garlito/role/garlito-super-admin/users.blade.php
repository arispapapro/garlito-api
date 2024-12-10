<?php
    // Utilities
    use App\Configuration\GarlitoApiConfiguration;
    use Illuminate\Support\Carbon;
?>
<!-- Extend to default authentication layout -->
@extends('garlito.layouts.admin')


<!-- Set Page Title -->
@section('title', 'Users')


@section('main-content')

    <div class="container-fluid">

        <!-- Page Header -->
        <section class="garlito-page-header d-flex align-items-center justify-content-between g-mb-15">
            <div>
                <h1>{{__('user.users_page.header.title')}}</h1>
                <h5>{{__('user.users_page.header.description')}}</h5>
            </div>
            <div>
                @include('garlito.role.garlito-super-admin.add-user-modal')
            </div>
        </section>

        <!-- Table -->
        <table class="table table-responsive table-bordered">
            <thead class="garlito-table-header">
            <tr>
                <th scope="col">{{__('user.table.headers.#')}}</th>
                <th scope="col">{{__('user.table.headers.first_name')}}</th>
                <th scope="col">{{__('user.table.headers.last_name')}}</th>
                <th scope="col">{{__('user.table.headers.email')}}</th>
                <th scope="col">{{__('user.table.headers.role')}}</th>
                <th scope="col">{{__('user.table.headers.language')}}</th>
                <th scope="col">{{__('user.table.headers.created_at')}}</th>
                <th scope="col">{{__('user.table.headers.actions')}}</th>
            </tr>
            </thead>
            <tbody class="garlito-table-body">
            @foreach ($users as $user)
                <tr>
                    <th>{{$user->id}}</th>
                    <th>{{$user->first_name}}</th>
                    <th>{{$user->last_name}}</th>
                    <th>{{$user->email}}</th>
                    <th>{{$user->role->label}}</th>
                    <th>{{$user->language->name ?? ''}}</th>
                    <th>{{Carbon::parse($user->created_at)}}</th>
                    <th>
                        <div class="d-flex align-items-center justify-content-center">
                            <a  class="garlito-table-button edit g-mr-10" href="{{url('user/' . $user->id )}}">
                                <x-gmdi-edit-r/>
                            </a>
                            @include('garlito.role.garlito-super-admin.delete-user-modal', [ 'user' => $user ])
                        </div>

                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>



    <div class="container">
        {{ $users->links() }}
    </div>


@endsection


