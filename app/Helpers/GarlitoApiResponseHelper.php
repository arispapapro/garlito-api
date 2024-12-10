<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class GarlitoApiResponseHelper
{
   public static function json_response( array $value = array() ): JsonResponse
    {
        return response()->json($value);
    }


    public static function getManyRequestsError( $message ): JsonResponse{

        //Config Status
        $status = 429;
        $main_message = "bad_request";

        //If User Doesnt insert any parameters.
        if(!$message){
            return response()->json([
                'message' => $main_message ,
                'status_message' => 'error',
                'data' => [] ,
                'status' => $status], 200);
        }

        if($message){
            return response()->json(['message' => $message , 'status_message' => 'error', 'status' => $status], $status);
        }

        //Empty Response
        return response()->json([]);
    }

   public static function getErrorResponse( $message ): JsonResponse{

        //Config Status
        $status = 400;
        $main_message = "bad_request";

        //If User Doesnt insert any parameters.
        if(!$message){
            return response()->json([
                'message' => $main_message ,
                'status_message' => 'error',
                'data' => [] ,
                'status' => $status], 200);
        }

        if($message){
            return response()->json(['message' => $message , 'status_message' => 'error', 'status' => $status], $status);
        }

        //Empty Response
        return response()->json([]);
    }

    public static function getPasswordNotMatchResponse(): JsonResponse{
        //Config Status
        $status = 401;
        $main_message = "Your password does not match.";
        return response()->json(['message' => $main_message , 'status' => $status, 'status_message' => 'password_mismatch' ], $status);
    }

   public static function getUnauthorizedResponse(): JsonResponse{
        //Config Status
        $status = 401;
        $main_message = "You are not authorized to access this endpoint.";
        return response()->json(['message' => $main_message , 'status' => $status, 'status_message' => 'unauthorized' ], $status);
    }

   public static function getNotFoundResponse(string $something): JsonResponse{
        //Config Status
        $status = 404;
        $main_message = $something . "_not_found";

        return response()->json(['message' => $main_message , 'status' => $status , 'data' => [] , 'status_message' => 'not_found'], $status);
    }

   public static function getSuccessResponse( $message = null , $data = null ): JsonResponse {

        //Config Status
        $status = 200;
        $main_message = "successful_request";
        $status_message = "success";

        //If User Doesnt insert any parameters.
        if(!$message && !$data){
            return response()->json(['message' => $main_message , 'data' => [] , 'status' => $status , 'status_message' => $status_message], $status);
        }

        if($message && $data){
            return response()->json(['message' => $message , 'data' => $data , 'status' => $status, 'status_message' => $status_message], $status);
        }

        if(!$message && $data){
            return response()->json(['message' => $main_message , 'data' => $data , 'status' => $status, 'status_message' => $status_message], $status);
        }

        if($message && !$data) {
            return response()->json(['message' => $message, 'data' => [], 'status' => $status, 'status_message' => $status_message], $status);
        }

        //Empty Response
        return response()->json([]);
    }

   public static function getInvalidInputsResponse($errors = [] , ): JsonResponse{
        $status = 400;
        $validation_errors = [];
        foreach(collect($errors) as $key => $value ){
            array_push($validation_errors , [ 'input' => $key , 'error' => $value ]);
        }
        return response()->json(['message' => [ 'validation_errors' => $validation_errors] , 'data' => [] , 'status' => $status ,  'status_message' => 'invalid_inputs'], $status);

    }

   public static function getNotPermittedToDoActionResponse($action): JsonResponse{
        $status = 403;
        return response()->json(['message' => 'You are not permitted to ' . $action , 'data' => [] , 'status' => $status ,  'status_message' => 'not_permitted_action'], 200);
    }

    public static function getForbiddenResponse(): JsonResponse{
        //Config Status
        $status = 403;
        $main_message = "Your are not permitted to access this endpoint";
        return response()->json(['message' => $main_message , 'status' => $status, 'status_message' => 'forbidden_access' ], $status);
    }

   public static function getInvalidParametersResponse($errors = []): JsonResponse{
        $status = 400;
        $validation_errors = [];
        foreach(collect($errors) as $key => $value ){
            array_push($validation_errors , [ 'input' => $key , 'error' => $value ]);
        }
        return response()->json(['message' => [ 'validation_errors' => $validation_errors] , 'data' => [] , 'status' => $status ,  'status_message' => 'invalid_parameters'], 200);

    }



}
