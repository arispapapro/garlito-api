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


<!-- Modal -->
<div id="garlitoEditUserModal"  class="garlito-edit-user-modal modal modal-xl" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">{{__('user.edit.modal_title')}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="garlitoEditUserForm{{$user->id}}" class="garlito-form">
            <div class="modal-body">



            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{__('buttons.edit')}}</button>
            </div>
            </form>
        </div>
    </div>
</div>

