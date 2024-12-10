$( document ).ready(function() {



    const app_url = 'http://localhost:8000';

    // Admin nav Element.
    const AdminMenu = $('#AdminMenu');

    // Sidebar
    const sidebar = $('#garlitoSidebar');
    const sidebar_button_holder = $('#garlitoSidebarButtonHolder');
    const sidebar_open_button = $('#garlitoSidebarButtonOpen');
    const sidebar_close_button = $('#garlitoSidebarButtonClose');

    // Forms
    const add_user_modal_form = $('#garlitoAddUserForm');

    // Modals
    const add_user_modal = $('#garlitoAddUserModal');
    const add_user_modal_button = $('#garlitoAddUserModalButton');

    let is_sidebar_open = true;

    // Main Holder
    const main_holder = $('#garlitoMainHolder');




    // Attach All Events
    attach_events();

    function attach_events(){

        // On Sidebar Open Button Click
        if(sidebar_open_button){
            sidebar_open_button.on('click', () => {
                if(is_sidebar_open){
                    close_sidebar();
                }else{
                    open_sidebar();
                }
            })
        }

        // On Sidebar Close Button Click
        if(sidebar_close_button){
            sidebar_close_button.on('click', () => {
                if(is_sidebar_open){
                    close_sidebar();
                }else{
                    open_sidebar();
                }
            })
        }


        // On Add User Modal Button Click
        if(add_user_modal_button){
            add_user_modal_button.on('click', () => {

                if(add_user_modal_form){
                    // Reset All Form Values
                    add_user_modal_form.trigger("reset");
                }
            })
        }

        // On Submission of Add User Form
        if(add_user_modal_form){
            add_user_modal_form.on('submit', function(event) {

                event.preventDefault();

                $.ajax({
                    url: app_url + '/user',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: $(this).serialize(),
                    success: function(response) {

                        // Clear All Previous Errors
                        add_user_modal_form.find('.invalid-feedback').each(function() {
                            $(this).text('');
                        });

                        // Remove Previous Invalid Class
                        add_user_modal_form.find('.form-control').each(function() {
                            $(this).removeClass('is-invalid');
                        });


                        if(response){
                            switch(response.status_message){
                                case('success'):{

                                    // Handle success (e.g., close the modal and show a success message)
                                    add_user_modal.modal('hide');

                                    // Refresh Page
                                    location.reload();

                                    break;
                                }
                                case('invalid_inputs'):{

                                    if(response && response.message && response.message.validation_errors){
                                        response.message.validation_errors.forEach((error) => {
                                            var input = add_user_modal_form.find('[name="' + error['input'] + '"]');
                                            input.addClass('is-invalid');
                                            input.next('.invalid-feedback').text(error['error'][0]);
                                        })
                                    }

                                    break;
                                }
                            }
                        }

                    },
                    error: function (request, status, error) {
                        alert(request.responseText);
                    }
                });
            });
        }

    }

    function update_user( user_id ){
        console.log(user_id);
    }

    function close_sidebar(){
        if(sidebar){

            sidebar.addClass('closed');
            main_holder.addClass('closed-sidebar');


            // Hide All Sidebar Items Labels
            $('.sidebar-item-label').hide()

            // Hide All Sidebar Categories
            $('.sidebar-category').hide()

            sidebar_button_holder.removeClass('justify-content-end');
            sidebar_button_holder.addClass('justify-content-center');

            sidebar_open_button.show();
            sidebar_close_button.hide();

            is_sidebar_open = false;
        }
    }

    function open_sidebar(){
        if(sidebar){

            sidebar.removeClass('closed');
            main_holder.removeClass('closed-sidebar');

            sidebar_button_holder.removeClass('justify-content-center');
            sidebar_button_holder.addClass('justify-content-end');

            // Show All Sidebar Items Labels
            $('.sidebar-item-label').show()

            // Show All Sidebar Categories
            $('.sidebar-category').show()

            sidebar_open_button.hide();
            sidebar_close_button.show();


            is_sidebar_open = true;
        }
    }


});
