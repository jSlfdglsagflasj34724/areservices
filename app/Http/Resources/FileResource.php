<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->file_name,
            'type' => $this->file_type,
            'size' => $this->file_size,
            'image_url' => asset('storage/'.$this->file_name),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
