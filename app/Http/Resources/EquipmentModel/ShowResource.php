<?php

namespace App\Http\Resources\EquipmentModel;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="EquipmentModelShowResource",
 *     title="Ресурс модели оборудования",
 *     description="Формат данных модели оборудования",
 *     @OA\Property(property="data", type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="equipment_brand", type="string", example="HP"),
 *         @OA\Property(property="title", type="string", example="EXP-123"),
 *     )
 * )
 */
class ShowResource extends JsonResource
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
