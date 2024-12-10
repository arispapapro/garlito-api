<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'login' => [
        'form' => [
            'email' => [
                'label' => 'Email Address',
                'placeholder' => 'Enter your email address.'
            ],
            'password' => [
                'label' => 'Password',
                'placeholder' => 'Enter your password.'
            ],
            'button' => 'Submit'
        ],
        'errors' => [
            'credentials' => 'The provided credentials do not match our records.',
            'email_not_exist' => 'This email address does not belong to any user.',
            'not_activated' => 'Your account is not activated.',
            'forbidden' => 'You are not authorized to access this system.'
        ]
    ],

];
