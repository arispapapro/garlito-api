<?php

    // Models
    use App\Models\Role;

    // Utilities
    use App\Configuration\GarlitoApiConfiguration;

    $roles = Role::all();

    $role_options = [];

    foreach($roles as $role){
        $role_options[] = ['label' => $role->label , 'value' => $role->id];
    }

?>
<button
    type="button"
    class="btn btn-primary"
    data-bs-toggle="modal"
    data-bs-target="#garlitoAddUserModal"
    id="garlitoAddUserModalButton">
    {{__('user.add.button')}}
</button>

<!-- Modal -->
<div id="garlitoAddUserModal"  class="modal modal-xl" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">{{__('user.add.modal_title')}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="garlitoAddUserForm" class="garlito-form" method="POST" action="{{url('user')}}">
            <div class="modal-body">

                    @csrf

                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-xl-6 col-xxl-6">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">{{__('user.add.form.first_name.label')}}</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="first_name"
                                    name="first_name"
                                    required
                                    placeholder="{{__('user.add.form.first_name.placeholder')}}">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-xl-6 col-xxl-6">
                            <div class="mb-3">
                                <label for="last_name" class="form-label">{{__('user.add.form.last_name.label')}}</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="last_name"
                                    name="last_name"
                                    required
                                    placeholder="{{__('user.add.form.last_name.placeholder')}}">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-xl-12 col-xxl-12">
                            <div class="mb-3">
                                <label for="email" class="form-label">{{__('user.add.form.email.label')}}</label>
                                <input
                                    autocomplete="email"
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    required
                                    placeholder="{{__('user.add.form.email.placeholder')}}">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-xl-6 col-xxl-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">{{__('user.add.form.password.label')}}</label>
                                <input
                                    autocomplete="new-password"
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    required
                                    placeholder="{{__('user.add.form.password.placeholder')}}">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-xl-6 col-xxl-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">{{__('user.add.form.password_confirmation.label')}}</label>
                                <input
                                    autocomplete="new-password"
                                    type="password"
                                    class="form-control"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    required
                                    placeholder="{{__('user.add.form.password_confirmation.placeholder')}}">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-xl-12 col-xxl-12">
                            <div class="mb-3">
                                <label for="email" class="form-label">{{__('user.add.form.role.label')}}</label>
                                <select required name="role_id" class="form-select" aria-label="Default select example">
                                    @foreach($role_options as $option)
                                        <option value="{{$option['value']}}">{{$option['label']}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{__('buttons.add')}}</button>
            </div>
            </form>
        </div>
    </div>
</div>

