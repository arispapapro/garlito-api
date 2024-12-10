
<button
    type="button"
    class="garlito-table-button delete"
    id="garlitoDeleteUserModalButton{{$user->id}}">
    <x-gmdi-delete-r/>
</button>
<div id="garlitoDeleteUserModal{{$user->id}}"  class="modal modal-xl" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">{{__('user.delete.modal_title')}}</h1>
                <button  id="garlitoDeleteUserModalDeleteButton{{$user->id}}" type="button" class="btn-close"  aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf

                <p>{{__('user.delete.delete_prompt_text', [ 'first_name' => $user->first_name , 'last_name' => $user->last_name])}}</p>
            </div>
            <div class="modal-footer">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <button id="garlitoDeleteUserNoButton{{$user->id}}" type="button" class="btn btn-primary yes-button g-mr-25">{{__('user.delete.no_button') }}</button>

                    <form id="garlitoDeleteUserForm{{$user->id}}" class="garlito-form" method="POST" action="{{url('user/' . $user->id . '/delete')}}">
                        @csrf
                        <button id="garlitoDeleteUserYesButton{{$user->id}}" type="submit" class="btn btn-primary no-button">{{__('user.delete.yes_button') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{asset('/js/jquery-3.7.1.min.js')}}"></script>

<script>
    $( document ).ready(function() {

        const delete_user_modal_button = $('#garlitoDeleteUserModalButton{{$user->id}}');
        const delete_user_modal_close_button = $('#garlitoDeleteUserModalDeleteButton{{$user->id}}');
        const delete_user_modal = $('#garlitoDeleteUserModal{{$user->id}}');
        const delete_user_yes_button = $('#garlitoDeleteUserYesButton{{$user->id}}');
        const delete_user_no_button = $('#garlitoDeleteUserNoButton{{$user->id}}');


        if(delete_user_modal_button && delete_user_modal){
            delete_user_modal_button.on('click' , () => {
                delete_user_modal.show();
            })
        }

        if(delete_user_modal_close_button && delete_user_modal){
            delete_user_modal_close_button.on('click' , () => {
                delete_user_modal.hide();
            })
        }

        if(delete_user_yes_button && delete_user_no_button &&  delete_user_modal){

            delete_user_yes_button.on('click' , () => {
                console.log('clicked');
            })

            delete_user_no_button.on('click' , () => {

                delete_user_modal.hide();
            })
        }
    });
</script>
