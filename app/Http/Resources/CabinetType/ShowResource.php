<?php

namespace App\Http\Resources\CabinetType;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CabinetTypeShowResource",
 *     title="Ресурс типа кабинета",
 *     description="Формат данных типа кабинета",
 *     @OA\Property(property="data", type="object",
 *         @OA\Property(property="title", type="string", example="Лаборатория"),
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
            'title' => $this->title
        ];
    }
}
