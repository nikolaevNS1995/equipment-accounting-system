<?php

namespace App\Http\Resources\EquipmentModel;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="EquipmentModelIndexResource",
 *     title="Ресурс списка моделей оборудования",
 *     description="Формат данных моделей оборудования при получении списка",
 *     @OA\Property(property="data", type="array",
 *         @OA\Items(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="equipment_type", type="string", example="HP"),
 *             @OA\Property(property="title", type="string", example="EXP-123"),
 *         )
 *     )
 * )
 */
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
