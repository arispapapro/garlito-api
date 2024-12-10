<?php
// Utilities
use App\Configuration\GarlitoApiConfiguration;
use Illuminate\Support\Carbon;
?>
    <!-- Extend to default authentication layout -->
@extends('garlito.layouts.admin')


<!-- Set Page Title -->
@section('title', 'Access Tokens')


@section('main-content')

    <div class="container-fluid">

        <!-- Page Header -->
        <section class="garlito-page-header d-flex align-items-center justify-content-between g-mb-15">
            <div>
                <h1>{{__('access-token.access_tokens_page.header.title')}}</h1>
                <h5>{{__('access-token.access_tokens_page.header.description')}}</h5>
            </div>
            <div>
            </div>
        </section>

        <!-- Table -->
        <table class="table table-responsive table-bordered">
            <thead class="garlito-table-header">
            <tr>
                <th>{{__('access-token.table.headers.#')}}</th>
                <th>{{__('access-token.table.headers.user_id')}}</th>
                <th>{{__('access-token.table.headers.client_id')}}</th>
                <th>{{__('access-token.table.headers.name')}}</th>
                <th>{{__('access-token.table.headers.scopes')}}</th>
                <th>{{__('access-token.table.headers.revoked')}}</th>
                <th>{{__('access-token.table.headers.created_at')}}</th>
                <th>{{__('access-token.table.headers.updated_at')}}</th>
                <th>{{__('access-token.table.headers.actions')}}</th>
            </tr>
            </thead>
            <tbody class="garlito-table-body">
            @foreach ($access_tokens as $access_token)
                <tr>
                    <th >{{$access_token->id}}</th>
                    <th>{{$access_token->user_id}}</th>
                    <th>{{$access_token->client_id}}</th>
                    <th>{{$access_token->name}}</th>
                    <th>{{$access_token->scopes}}</th>
                    <th>{{$access_token->revoked}}</th>
                    <th>{{Carbon::parse($access_token->created_at)}}</th>
                    <th>{{Carbon::parse($access_token->updated_at)}}</th>
                    <th>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>



    <div class="container">
        {{ $access_tokens->links() }}
    </div>


@endsection

