<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'first_name' => $this->first_name ?? '',
            'middle_name' => $this->middle_name ?? '',
            'last_name' => $this->last_name ?? '',
            'full_name' => ($this->first_name . ' '  . $this->last_name ) ?? '',
            'gender' => $this->gender ?? '',
            'email' => $this->email ?? '',
            'role' => $this->role->slug ?? ''
        ];
    }
}
