<?php

namespace App\Http\Resources\Furniture;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="FurnitureShowResource",
 *     title="Ресурс мебели",
 *     description="Формат данных мебели",
 *     @OA\Property(property="data", type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="furniture_type", type="string", example="Стол"),
 *         @OA\Property(property="cabinet", type="integer", example=321),
 *         @OA\Property(property="inventory_number", type="integer", example="Белый 140х80х75"),
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
            'furniture_type' => $this->furnitureType->title,
            'cabinet' => $this->cabinet->cabinet_number,
            'inventory_number' => $this->inventory_number,
        ];
    }
}
