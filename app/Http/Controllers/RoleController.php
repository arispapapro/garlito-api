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

        $this->model_single_name =  'role';
        $this->model_plural_name =  'roles';
        $this->option_label =  'slug';
        $this->option_value =  'id';
        $this->db_table =  'roles';
        $this->default_resource =  RoleResource::class;
        $this->model = Role::class;
        $this->create_validation_rules = function(): array {
            return [
                'label' => ['string', 'required'],
                'description' => ['string', 'required'],
                'slug' => ['required', Rule::unique($this->db_table)]
            ];
        };
        $this->update_validation_rules = function ($model = null ): array {
            return [
                'label' => ['string'],
                'description' => ['string'],
                'slug' => ['string', Rule::unique($this->db_table)->ignore($model)]
            ];
        };
    }

}
