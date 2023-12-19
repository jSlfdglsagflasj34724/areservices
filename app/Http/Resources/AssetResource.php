<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
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
            'type_id' => $this->asset_type_id,
            'asset_type' => new AssetTypeResource($this->whenLoaded('assetType')),
            'brand' => $this->brand_name,
            'serial' => $this->serial_number,
            'model' => $this->model,
            'url' => $this->barcode_url,
            'year' => $this->year,
            'other' => $this->other_asset_type,
            'company' => $this->company_name,
            'location' => $this->location,
            'landmark' => $this->landmark,
            'tag' => $this->asset_tag,
            'check' => $this->check,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at, 
        ];
    }
}
