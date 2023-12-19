<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'addresss' => $this->whenLoaded('customer', $this->customer->address),
            'phone' => (string) $this->whenLoaded('customer', $this->customer->phone_no),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

    }
}