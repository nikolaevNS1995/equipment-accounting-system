<?php

namespace App\Http\Resources\EquipmentBrand;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="EquipmentBrandShowResource",
 *     title="Ресурс брендов оборудования",
 *     description="Формат данных брендов оборудования",
 *     @OA\Property(property="data", type="object",
 *          @OA\Property(property="id", type="integer", example=1),
 *          @OA\Property(property="equipment_type", type="string", example="Системный блок"),
 *          @OA\Property(property="title", type="string", example="HP"),
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
            'equipment_type' => $this->equipmentType->title,
            'title' => $this->title,
        ];
    }
}
