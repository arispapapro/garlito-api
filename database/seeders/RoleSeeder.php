<?php

namespace Database\Seeders;

use App\Configuration\GarlitoApiConfiguration;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Get Default System Roles.
        $default_api_roles = GarlitoApiConfiguration::get_default_api_roles();

        // Create Role
        foreach($default_api_roles as $role){

            // Create Role.
            Role::create($role);
        }
    }
}
