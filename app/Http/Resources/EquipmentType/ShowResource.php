<?php

namespace App\Http\Resources\EquipmentType;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="EquipmentTypeShowResource",
 *     title="Ресурс типа оборудования",
 *     description="Формат данных типа оборудования",
 *     @OA\Property(property="data", type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="title", type="string", example="Системный блок"),
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
            'title' => $this->title,
        ];
    }
}
