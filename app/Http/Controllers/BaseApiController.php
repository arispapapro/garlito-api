<?php

namespace App\Http\Controllers;

// Utilities
use App\Helpers\GarlitoApiResponseHelper;
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
    public $is_crud_controller = false;

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

    //------------------------------------------------------------------------------------------------------------------
    // Default CRUD Functions
    //------------------------------------------------------------------------------------------------------------------


    public function model_options(): JsonResponse {

        // If it's not a crud controller
        if(!$this->is_crud_controller){ return GarlitoApiResponseHelper::getErrorResponse('not_crud_controller');}

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
        return GarlitoApiResponseHelper::getSuccessResponse($this->model_single_name . '_options', $options);
    }

    public function create_model(Request $request): JsonResponse {

        // If it's not a crud controller
        if(!$this->is_crud_controller){ return GarlitoApiResponseHelper::getErrorResponse('not_crud_controller');}

        // Get all input values from request
        $input = $request->all();

        // Validation Rules
        $validator = Validator::make($input, $this->create_validation_rules());

        // If its not validated return response with error messages.
        if($validator->fails()){return GarlitoApiResponseHelper::getInvalidInputsResponse($validator->errors());}

        // Create New Model
        $new_model = $this->model::create($request->all());

        // Return Success Response
        return GarlitoApiResponseHelper::getSuccessResponse('single_' . $this->model_single_name .'_created' , $this->default_resource::make($new_model));
    }

    public function update_model(Request $request, int $id): JsonResponse {

        // If it's not a crud controller
        if(!$this->is_crud_controller){ return GarlitoApiResponseHelper::getErrorResponse('not_crud_controller');}

        // Search Single Model.
        $search_model = $this->model::find($id);

        // Return Not Found Response
        if(!$search_model){ return GarlitoApiResponseHelper::getNotFoundResponse($this->model_single_name);}

        // Get all input values from request
        $input = $request->all();

        // Validation Rules
        $validator = Validator::make($input, $this->update_validation_rules($search_model));

        // If its not validated return response with error messages.
        if($validator->fails()){return GarlitoApiResponseHelper::getInvalidInputsResponse($validator->errors());}

        // Update Every Value of the model.
        foreach($request->all() as $key => $value ){
            $search_model[$key] = $value;
        }

        // Update Model
        $search_model->save();

        // Re-Fetch Model
        $search_model = $this->model::find($id);

        // Return Success Response
        return GarlitoApiResponseHelper::getSuccessResponse('single_' . $this->model_single_name. '_updated' , $this->default_resource::make($search_model));


    }
    public function delete_model(int $id): JsonResponse {

        // If it's not a crud controller
        if(!$this->is_crud_controller){ return GarlitoApiResponseHelper::getErrorResponse('not_crud_controller');}

        // Search Single Model.
        $search_model = $this->model::find($id);

        // Return Not Found Response
        if(!$search_model){ return GarlitoApiResponseHelper::getNotFoundResponse($this->model_single_name);}

        // Delete Model
        $search_model->delete();

        // Return Success Response
        return GarlitoApiResponseHelper::getSuccessResponse( $this->model_single_name . '_deleted', []);

    }

    public function single_model(int $id): JsonResponse {

        // If it's not a crud controller
        if(!$this->is_crud_controller){ return GarlitoApiResponseHelper::getErrorResponse('not_crud_controller');}

        // Search Single Model.
        $search_model = $this->model::find($id);

        // Return Not Found Response
        if(!$search_model){ return GarlitoApiResponseHelper::getNotFoundResponse($this->model_single_name);}

        // Return Success Response
        return GarlitoApiResponseHelper::getSuccessResponse('single_' . $this->model_single_name , $this->default_resource::make($search_model));

    }

    public function all_models(): JsonResponse {

        // If it's not a crud controller
        if(!$this->is_crud_controller){ return GarlitoApiResponseHelper::getErrorResponse('not_crud_controller');}

        // Search Single Model.
        $all_models = DB::table($this->db_table)->get();

        // Return Success Response
        return GarlitoApiResponseHelper::getSuccessResponse('single_' . $this->model_single_name , $this->default_resource::collection($all_models));
    }

}
