<?php

namespace App\Http\Resources\CabinetType;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CabinetTypeIndexResource",
 *     title="Ресурс списка типов кабинетов",
 *     description="Формат данных типов кабинетов при получении списка",
 *     @OA\Property(property="data", type="array",
 *         @OA\Items(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="title", type="string", example="Лаборатория"),
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
            'title' => $this->title
        ];
    }
}
