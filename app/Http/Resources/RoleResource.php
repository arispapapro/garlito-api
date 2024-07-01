<?php

namespace App\Http\Resources;

use App\Helpers\GarlitoResourceHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...GarlitoResourceHelper::get_id_timestamps($this),
            'label' => $this->label,
            'slug' => $this->slug,
            'description' => $this->description,
        ];
    }

}
