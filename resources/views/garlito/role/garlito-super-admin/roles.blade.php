<!-- Extend to default authentication layout -->
@extends('garlito.layouts.admin')


<!-- Set Page Title -->
@section('title', 'Roles')


@section('main-content')

    <div class="container-fluid">
        <!-- Page Header -->
        <section class="garlito-page-header d-flex align-items-center justify-content-between g-mb-15">
            <div>
                <h1>{{__('role.roles_page.header.title')}}</h1>
                <h5>{{__('role.roles_page.header.description')}}</h5>
            </div>
            <div>
            </div>
        </section>

        <!-- Table -->
        <table class="table table-bordered">
            <thead class="garlito-table-header">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Label</th>
                <th scope="col">Slug</th>
                <th scope="col">Description</th>
                <th scope="col">Created At</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody class="garlito-table-body">
            @foreach ($roles as $role)
                <tr>
                    <th>{{$role->id}}</th>
                    <th>{{$role->label}}</th>
                    <th>{{$role->slug}}</th>
                    <th>{{$role->description}}</th>
                    <th>{{$role->created_at}}</th>
                    <th></th>
                </tr>
            @endforeach
            </tbody>
        </table>


    </div>

    <div class="container">
        {{ $roles->links() }}
    </div>

@endsection

