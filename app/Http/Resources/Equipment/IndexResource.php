<?php

namespace App\Http\Resources\Equipment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="EquipmentIndexResource",
 *     title="Ресурс списка оборудования",
 *     description="Формат данных оборудования при получении списка",
 *     @OA\Property(property="data", type="array",
 *         @OA\Items(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="equipment_model", type="string", example="EXP-123"),
 *             @OA\Property(property="cabinet_id", type="integer", example=1),
 *             @OA\Property(property="inventory_number", type="integer", example=555555555),
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
            'equipment_model' => $this->equipmentModel->title,
            'cabinet_id' => $this->cabinet->cabinet_number,
            'inventory_number' => $this->inventory_number,
        ];
    }
}
