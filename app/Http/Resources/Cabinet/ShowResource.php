<?php

namespace App\Http\Resources\Cabinet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CabinetShowResource",
 *     title="Ресурс кабинета",
 *     description="Формат данных кабинета",
 *     @OA\Property(property="data", type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="cabinet_type", type="string", example="Лаборатория"),
 *         @OA\Property(property="building", type="string", example="Анадырский"),
 *         @OA\Property(property="title", type="string", example="Лаборатория информационных технологий"),
 *         @OA\Property(property="cabinet_number", type="integer", example=321),
 *         @OA\Property(property="floor", type="integer", example=3),
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
            'cabinet_type' => $this->cabinetType->title,
            'building' => $this->building->title,
            'title' => $this->title,
            'cabinet_number' => $this->cabinet_number,
            'floor' => $this->floor,
        ];
    }
}
