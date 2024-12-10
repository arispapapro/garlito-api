<?php
// Utilities
use App\Configuration\GarlitoApiConfiguration;
use Illuminate\Support\Carbon;
?>
    <!-- Extend to default authentication layout -->
@extends('garlito.layouts.admin')


<!-- Set Page Title -->
@section('title', 'Clients')


@section('main-content')

    <div class="container-fluid">

        <!-- Page Header -->
        <section class="garlito-page-header d-flex align-items-center justify-content-between g-mb-15">
            <div>
                <h1>{{__('client.clients_page.header.title')}}</h1>
                <h5>{{__('client.clients_page.header.description')}}</h5>
            </div>
            <div>
            </div>
        </section>

        <!-- Table -->
        <table class="table table-responsive table-bordered">
            <thead class="garlito-table-header">
            <tr>
                <th>{{__('client.table.headers.#')}}</th>
                <th>{{__('client.table.headers.user_id')}}</th>
                <th>{{__('client.table.headers.secret')}}</th>
                <th>{{__('client.table.headers.provider')}}</th>
                <th>{{__('client.table.headers.redirect')}}</th>
                <th>{{__('client.table.headers.personal_access_client')}}</th>
                <th>{{__('client.table.headers.password_client')}}</th>
                <th>{{__('client.table.headers.revoked')}}</th>
                <th>{{__('client.table.headers.created_at')}}</th>
                <th>{{__('client.table.headers.updated_at')}}</th>
                <th>{{__('client.table.headers.actions')}}</th>
            </tr>
            </thead>
            <tbody class="garlito-table-body">
            @foreach ($clients as $client)
                <tr>
                    <th>{{$client->id}}</th>
                    <th>{{$client->user_id}}</th>
                    <th>{{$client->secret}}</th>
                    <th>{{$client->provider}}</th>
                    <th>{{$client->redirect}}</th>
                    <th>{{$client->personal_access_client}}</th>
                    <th>{{$client->password_client}}</th>
                    <th>{{$client->revoked}}</th>
                    <th>{{Carbon::parse($client->created_at)}}</th>
                    <th>{{Carbon::parse($client->updated_at)}}</th>
                    <th>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>



    <div class="container">
        {{ $clients->links() }}
    </div>


@endsection

