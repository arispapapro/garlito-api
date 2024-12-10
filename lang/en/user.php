<?php

return [
    'users_page' => [
        'header' => [
            'title' => 'Users',
            'description' => 'Add, Edit & Delete Users.'
        ]
    ],
    'table' => [
      'headers' => [
          '#' => '#',
          'first_name' => 'First Name',
          'last_name' => 'Last Name',
          'email' => 'Email',
          'role' => 'Role',
          'language' => 'Language',
          'created_at' => 'Created At',
          'actions' => 'Actions'
      ]
    ],
    'add' => [
        'button' => 'Add User',
        'modal_title' => 'Add New User',
        'form' => [
            'first_name' => [
                'label' => 'First Name',
                'placeholder' => 'Enter First Name.'
            ],
            'last_name' => [
                'label' => 'Last Name',
                'placeholder' => 'Enter Last Name.'
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'Enter Email.'
            ],
            'password' => [
                'label' => 'Password',
                'placeholder' => 'Enter Password.'
            ],
            'password_confirmation' => [
                'label' => 'Password Confirmation',
                'placeholder' => 'Enter Password Confirmation.'
            ],
            'role' => [
                'label' => 'Role',
                'placeholder' => 'Select a Role.'
            ],
            'language' => [
                'label' => 'Language',
                'placeholder' => 'Select Language.'
            ]
        ]
    ],
    'edit' => [
        'button' => 'Edit User',
        'modal_title' => 'Edit User',
        'form' => [
            'first_name' => [
                'label' => 'First Name',
                'placeholder' => 'Enter First Name.'
            ],
            'last_name' => [
                'label' => 'Last Name',
                'placeholder' => 'Enter Last Name.'
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'Enter Email.'
            ],
            'password' => [
                'label' => 'Password',
                'placeholder' => 'Enter Password.'
            ],
            'password_confirmation' => [
                'label' => 'Password Confirmation',
                'placeholder' => 'Enter Password Confirmation.'
            ],
            'role' => [
                'label' => 'Role',
                'placeholder' => 'Select a Role.'
            ],
            'language' => [
                'label' => 'Language',
                'placeholder' => 'Select Language.'
            ]
        ],
        'success_message' => 'You have successfully edited user!'
    ],
    'delete' => [
        'button' => 'Delete User',
        'modal_title' => 'Delete User',
        'yes_button' => 'Yes',
        'no_button' => 'No',
        'delete_prompt_text' => 'Are you sure you want to delete :first_name :last_name account?'
    ]
];
