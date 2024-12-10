<?php

namespace App\Http\Controllers;

// Utilities
use AllowDynamicProperties;
use App\Http\Resources\RoleResource;
use Illuminate\Http\JsonResponse;

// Helpers
use App\Helpers\GarlitoModelHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;
use Illuminate\Http\Request;

// Models
use App\Models\Role;


#[AllowDynamicProperties]
class RoleController extends BaseApiController
{

    public function __construct()
    {
        //------------------------------------------------------------------------------------------------------------------
        // Controller Configuration
        //------------------------------------------------------------------------------------------------------------------

        // Set CRUD Controller Functionality On.
        $this->is_crud_controller = true;

        // Single Model Name : E.g Apple
        $this->model_single_name =  'role';

        // Plural Model Name : E.g Apples
        $this->model_plural_name =  'roles';

        // The Label to Select in Dropdown Lists
        $this->option_label =  'slug';

        // The Value to Select in Dropdown Lists
        $this->option_value =  'id';

        // Table Name in the Database
        $this->db_table =  'roles';

        // The Basic Resource To Be Used For This Model.
        $this->default_resource =  RoleResource::class;

        // The Model Itself
        $this->model = Role::class;

        // Validations when you create a new model instance.
        $this->create_validation_rules = function(): array {
            return [
                'label' => ['string', 'required'],
                'description' => ['string', 'required'],
                'slug' => ['required', Rule::unique($this->db_table)]
            ];
        };

        // Validations when you update a new model instance.
        $this->update_validation_rules = function ($model = null ): array {
            return [
                'label' => ['string'],
                'description' => ['string'],
                'slug' => ['string', Rule::unique($this->db_table)->ignore($model)]
            ];
        };
    }

}
