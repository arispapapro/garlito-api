<?php

return [
    'access_tokens_page' => [
        'header' => [
            'title' => 'Access Tokens',
            'description' => 'Preview all user access tokens & revoke them.'
        ],
    ],
    'table' => [
        'headers' => [
            '#' => '#',
            'user_id' => 'User',
            'client_id' => 'Client',
            'name' => 'Name',
            'scopes' => 'Scopes',
            'revoked' => 'Revoked',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'actions' => 'Actions'

        ]
    ]
];
