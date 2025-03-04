<?php

namespace App\Http\Resources\EquipmentModel;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
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
            'equipment_brand' => $this->equipmentBrand->title,
            'title' => $this->title,
        ];
    }
}
