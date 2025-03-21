<?php

namespace App\Http\Resources\Role;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="RoleShowResource",
 *     title="Ресурс роли",
 *     description="Формат данных роли",
 *     @OA\Property(property="data", type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="title", type="string", example="Инженер"),
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
