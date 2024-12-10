<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laravel\Passport\Client;
use Laravel\Passport\PersonalAccessClient;

class PassportClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Password Grant Client
       $password_grant_client =  Client::create([
            'user_id' => null,
            'name' => 'Password Grant Client',
            'secret' => env('PASSPORT_PASSWORD_GRANT_CLIENT_SECRET_PASSWORD'),
            'redirect' => env('APP_URL') . '/callback',
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
        ]);

        // Create Personal Access Client
        $personal_access_client = Client::create([
            'user_id' => null,
            'name' => 'Personal Access Client',
            'secret' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET_PASSWORD'),
            'redirect' => env('APP_URL') . '/callback',
            'personal_access_client' => true,
            'password_client' => false,
            'revoked' => false,
        ]);

        PersonalAccessClient::create([
            'client_id' => $personal_access_client->id,
        ]);

    }
}
