<?php

namespace App\Http\Controllers;

// Utilities
use App\Helpers\GarlitoModelHelper;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BaseApiController extends Controller
{

    //------------------------------------------------------------------------------------------------------------------
    // Controller Configuration
    //------------------------------------------------------------------------------------------------------------------

    // Model Settings
    public string $model_single_name = '';
    public string $model_plural_name = '';
    public string $option_label = '';
    public string $option_value = '';
    public string $db_table = '';
    public  $default_resource = null;
    public $model = null;

    public function create_validation_rules(): array {
        return [
            'label' => ['string', 'required'],
            'description' => ['string', 'required'],
            'slug' => ['required', Rule::unique($this->db_table)]
        ];
    }
    public function update_validation_rules($model = null ): array {
        return [
            'label' => ['string'],
            'description' => ['string'],
            'slug' => ['string', Rule::unique($this->db_table)->ignore($model)]
        ];
    }
    //------------------------------------------------------------------------------------------------------------------

    public function json_response( array $value = array() ): JsonResponse
    {
        return response()->json($value);
    }

    public function getErrorResponse( $message ): JsonResponse{

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
            return response()->json(['message' => $message , 'status_message' => 'error', 'status' => $status], 200);
        }

        //Empty Response
        return response()->json([]);
    }

    public function getUnauthorizedResponse(): JsonResponse{
        //Config Status
        $status = 401;
        $main_message = "api_responses.email_password_wrong";

        return response()->json(['message' => $main_message , 'status' => $status, 'status_message' => 'unauthorized' , 'data' => []], 200);
    }

    public function getNotFoundResponse(string $something): JsonResponse{
        //Config Status
        $status = 404;
        $main_message = $something . "_not_found";

        return response()->json(['message' => $main_message , 'status' => $status , 'data' => [] , 'status_message' => 'not_found'], 200);
    }

    public function getSuccessResponse( $message = null , $data = null ): JsonResponse {

        //Config Status
        $status = 200;
        $main_message = "successful_request";
        $status_message = "success";

        //If User Doesnt insert any parameters.
        if(!$message && !$data){
            return response()->json(['message' => $main_message , 'data' => [] , 'status' => $status , 'status_message' => $status_message], 200);
        }

        if($message && $data){
            return response()->json(['message' => $message , 'data' => $data , 'status' => $status, 'status_message' => $status_message], 200);
        }

        if(!$message && $data){
            return response()->json(['message' => $main_message , 'data' => $data , 'status' => $status, 'status_message' => $status_message], 200);
        }

        if($message && !$data) {
            return response()->json(['message' => $message, 'data' => [], 'status' => $status, 'status_message' => $status_message], 200);
        }

        //Empty Response
        return response()->json([]);
    }

    public function getInvalidInputsResponse($errors = [] , ): JsonResponse{
        $status = 400;
        $validation_errors = [];
        foreach(collect($errors) as $key => $value ){
            array_push($validation_errors , [ 'input' => $key , 'error' => $value ]);
        }
        return response()->json(['message' => [ 'validation_errors' => $validation_errors] , 'data' => [] , 'status' => $status ,  'status_message' => 'invalid_inputs'], 200);

    }

    public function getNotPermittedToDoActionResponse($action): JsonResponse{
        $status = 403;
        return response()->json(['message' => 'You are not permitted to ' . $action , 'data' => [] , 'status' => $status ,  'status_message' => 'not_permitted_action'], 200);
    }

    public function getInvalidParametersResponse($errors = []): JsonResponse{
        $status = 400;
        $validation_errors = [];
        foreach(collect($errors) as $key => $value ){
            array_push($validation_errors , [ 'input' => $key , 'error' => $value ]);
        }
        return response()->json(['message' => [ 'validation_errors' => $validation_errors] , 'data' => [] , 'status' => $status ,  'status_message' => 'invalid_parameters'], 200);

    }



    //------------------------------------------------------------------------------------------------------------------
    // Default CRUD Functions
    //------------------------------------------------------------------------------------------------------------------


    public function model_options(): JsonResponse {

        // Init Models Data
        $models = [];

        // If Database Table Configuration is Not Empty.
        if(isset($this->db_table) && $this->db_table != ''){

            // Fetch Model From Database
            $models = DB::table($this->db_table)->get();
        }

        // Get Model Options Formatted
        $options = GarlitoModelHelper::get_model_options($models, $this->option_label , $this->option_value);

        // Return Success Response
        return $this->getSuccessResponse($this->model_single_name . '_options', $options);
    }

    public function create_model(Request $request): JsonResponse {

        // Get all input values from request
        $input = $request->all();

        // Validation Rules
        $validator = Validator::make($input, $this->create_validation_rules());

        // If its not validated return response with error messages.
        if($validator->fails()){return $this->getInvalidInputsResponse($validator->errors());}

        // Create New Model
        $new_model = $this->model::create($request->all());

        // Return Success Response
        return $this->getSuccessResponse('single_' . $this->model_single_name .'_created' , $this->default_resource::make($new_model));
    }

    public function update_model(Request $request, int $id): JsonResponse {

        // Search Single Model.
        $search_model = $this->model::find($id);

        // Return Not Found Response
        if(!$search_model){ return $this->getNotFoundResponse($this->model_single_name);}

        // Get all input values from request
        $input = $request->all();

        // Validation Rules
        $validator = Validator::make($input, $this->update_validation_rules($search_model));

        // If its not validated return response with error messages.
        if($validator->fails()){return $this->getInvalidInputsResponse($validator->errors());}

        // Update Every Value of the model.
        foreach($request->all() as $key => $value ){
            $search_model[$key] = $value;
        }

        // Update Model
        $search_model->save();

        // Re-Fetch Model
        $search_model = $this->model::find($id);

        // Return Success Response
        return $this->getSuccessResponse('single_' . $this->model_single_name. '_updated' , $this->default_resource::make($search_model));


    }
    public function delete_model(int $id): JsonResponse {

        // Search Single Model.
        $search_model = $this->model::find($id);

        // Return Not Found Response
        if(!$search_model){ return $this->getNotFoundResponse($this->model_single_name);}

        // Delete Model
        $search_model->delete();

        // Return Success Response
        return $this->getSuccessResponse( $this->model_single_name . '_deleted', []);

    }

    public function single_model(int $id): JsonResponse {

        // Search Single Model.
        $search_model = $this->model::find($id);

        // Return Not Found Response
        if(!$search_model){ return $this->getNotFoundResponse($this->model_single_name);}

        // Return Success Response
        return $this->getSuccessResponse('single_' . $this->model_single_name , $this->default_resource::make($search_model));

    }

    public function all_models(): JsonResponse {

        // Search Single Model.
        $all_models = DB::table($this->db_table)->get();

        // Return Success Response
        return $this->getSuccessResponse('single_' . $this->model_single_name , $this->default_resource::collection($all_models));
    }

}
