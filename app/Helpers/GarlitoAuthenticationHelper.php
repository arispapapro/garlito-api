<?php

namespace App\Helpers;

use App\Models\User;
use http\Env\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GarlitoAuthenticationHelper
{


    //-----------------------------------------------------------------------//
    // CONFIGURATION --------------------------------------------------------//
    //-----------------------------------------------------------------------//
    //-----------------------------------------------------------------------//

    //- Passport Client Credentials------------------------------------------//
    private static string $api_url = "http://localhost:8000";
    //-----------------------------------------------------------------------//

    private static int $defaultAccessTokenExpirationInHours = 24;
    private static int $defaultRefreshTokenExpirationInHours = 24;
    private static int $defaultPersonalAccessTokenExpirationInHours = 24;


    public static function getAccessTokenExpirationInHours(): int {

        $expiration = env('PASSPORT_TOKEN_EXPIRATION_HOURS');

        if(isset($expiration)){
            return intval($expiration);
        }else{
            return self::$defaultAccessTokenExpirationInHours;
        }
    }

    public static function getOauthClientDetails(){
        return DB::table('oauth_clients')->where('password_client', 1)->first();
    }

    public static function getTokenDetails(string $email, string $password){
        try {

            $client_details = self::getOauthClientDetails();

            if($client_details){

                $url = self::$api_url .'/oauth/token';

                $response = Http::post($url, [
                    'grant_type' => 'password',
                    'client_id' => $client_details->id,
                    'client_secret' => $client_details->secret,
                    'username' => $email,
                    'password' => $password,
                ]);


                return $response->json();
            }else{
                return [];
            }
        } catch (\Throwable $e) { report($e); return response()->json($e->getMessage()); }

    }


    public static function getRefreshTokenDetails(string $refresh_token){
        try {

            $client_details = self::getOauthClientDetails();

            if($client_details){

                $url = self::$api_url .'/oauth/token';

                $response = Http::post($url, [
                    'grant_type' => 'refresh_token',
                    'client_id' => $client_details->id,
                    'client_secret' => $client_details->secret,
                    'refresh_token' => $refresh_token,
                ]);

                return $response->json();
            }else{
                return [];
            }
        } catch (\Throwable $e) { report($e); return response()->json($e->getMessage()); }

    }


    public static function getRefreshTokenExpirationInHours(): int {

        $expiration = env('PASSPORT_REFRESH_TOKEN_EXPIRATION_HOURS');

        if(isset($expiration)){
            return intval($expiration);
        }else{
            return self::$defaultRefreshTokenExpirationInHours;
        }
    }

    public static function getPersonalAccessTokenExpirationInHours(): int {

        $expiration = env('PASSPORT_PERSONAL_ACCESS_TOKEN_EXPIRATION_HOURS');

        if(isset($expiration)){
            return intval($expiration);
        }else{
            return self::$defaultPersonalAccessTokenExpirationInHours;
        }
    }


    public static function revokeAllTokensOfUser(int $user_id): void{
        $query = DB::table('oauth_access_tokens')->where('user_id', $user_id)->update([
            'revoked' => true
        ]);
    }



    public static function logout_web(): void{
        Auth::logout();
    }
}
