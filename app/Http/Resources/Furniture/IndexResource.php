<?php

namespace App\Http\Resources\Furniture;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="FurnitureIndexResource",
 *     title="Ресурс списка мебели",
 *     description="Формат данных мебели при получении списка",
 *     @OA\Property(property="data", type="array",
 *         @OA\Items(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="furniture_type", type="string", example="Стол"),
 *             @OA\Property(property="cabinet", type="integer", example=321),
 *             @OA\Property(property="inventory_number", type="integer", example=55555555),
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
            'furniture_type' => $this->furnitureType->title,
            'cabinet' => $this->cabinet->cabinet_number,
            'inventory_number' => $this->inventory_number,
        ];
    }
}
