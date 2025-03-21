<?php

namespace App\Http\Resources\Building;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="BuildingIndexResource",
 *     title="Ресурс списка площадок",
 *     description="Формат данных площадок при получении списка",
 *     @OA\Property(property="data", type="array", @OA\Items(
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="title", type="string", example="Анадырский"),
 *         @OA\Property(property="address", type="string", example="Москва, Анадырский проезд, 79"),
 *         @OA\Property(property="floor", type="integer", example=3),
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
            'title' => $this->title,
            'address' => $this->address,
            'floor' => $this->floor,
        ];
    }
}
