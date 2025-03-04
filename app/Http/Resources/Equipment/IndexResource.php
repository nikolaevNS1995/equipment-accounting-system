<?php

namespace App\Http\Resources\Equipment;

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
            'equipment_model' => $this->equipmentModel->title,
            'cabinet_id' => $this->cabinet->cabinet_number,
            'inventory_number' => $this->inventory_number,
        ];
    }
}
