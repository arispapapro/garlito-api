<?php

namespace App\Configuration;

class GarlitoApiConfiguration
{

    //------------------------------------------------------------------------------------------------------------------
    // Api Token Expiration ( 60s * N Time ) N = Minutes
    //------------------------------------------------------------------------------------------------------------------
    //const int GARLITO_API_TOKEN_EXPIRATION_SECONDS = 60 * 5;


    //------------------------------------------------------------------------------------------------------------------
    // Default API Roles
    //------------------------------------------------------------------------------------------------------------------

    const string DEFAULT_GARLITO_SUPER_ADMIN_ROLE_SLUG = 'garlito_super_admin';
    const string DEFAULT_GARLITO_USER_ROLE_SLUG = 'garlito_user';
    const array DEFAULT_API_ROLES = [
        [ 'label' => 'Garlito Super Admin' , 'slug' => 'garlito_super_admin' , 'description' => 'Garlito Super Admin Role Group.'],
        [ 'label' => 'User' , 'slug' => 'garlito_user' , 'description' => 'Users Role Group.'],
    ];


    //------------------------------------------------------------------------------------------------------------------
    // Default Authentication Settings
    //------------------------------------------------------------------------------------------------------------------

    const bool USE_EMAIL_VERIFICATION = true;

    //------------------------------------------------------------------------------------------------------------------
    // Default User Language
    //------------------------------------------------------------------------------------------------------------------

    const string DEFAULT_USER_LANGUAGE_CODE = 'en';

    //------------------------------------------------------------------------------------------------------------------
    // Default User Role
    //------------------------------------------------------------------------------------------------------------------
    const string DEFAULT_USER_ROLE_SLUG = 'garlito_user';


    //------------------------------------------------------------------------------------------------------------------
    // Theme: Primary Color
    //------------------------------------------------------------------------------------------------------------------
    const string GARLITO_THEME_PRIMARY_COLOR = '#03a9f4';


    //------------------------------------------------------------------------------------------------------------------
    // Default Web Pagination Number
    //------------------------------------------------------------------------------------------------------------------

    const int DEFAULT_WEB_PAGINATION_NUMBER = 5;


    // Default Constructor
    function __construct() {}


    // Get Default System Roles.
    public static function get_default_api_roles(): array
    {
        return self::DEFAULT_API_ROLES;
    }


    public static function use_email_verification(): bool
    {
        return self::USE_EMAIL_VERIFICATION;
    }







}
