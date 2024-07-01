<?php

namespace App\Configuration;

class GarlitoApiConfiguration
{

    //------------------------------------------------------------------------------------------------------------------
    // Controller Configuration
    //------------------------------------------------------------------------------------------------------------------
    const DEFAULT_API_ROLES = [
        [ 'label' => 'core.roles.admin' , 'slug' => 'admin' , 'description' => 'Admins Role Group.'],
        [ 'label' => 'core.roles.user' , 'slug' => 'user' , 'description' => 'Users Role Group.'],
    ];


    // Default Constructor
    function __construct($name) {}


    // Get Default System Roles.
    public static function get_default_api_roles(): array
   {
       return self::DEFAULT_API_ROLES;
   }


}
