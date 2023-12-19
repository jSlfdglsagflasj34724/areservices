<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobsResource extends JsonResource
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
            'name' => $this->job_name,
            'description' => $this->job_description,
            'priority_id' => $this->job_priority_id,
            'availability' => $this->availability,
            'priority' => new PriorityResource($this->whenLoaded('priority')),
            'status' => $this->status,
            'assets' =>  AssetResource::collection($this->whenLoaded('assets')),
            'attachments' => FileResource::collection($this->whenLoaded('file')),
            'due_at' => $this->due_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
