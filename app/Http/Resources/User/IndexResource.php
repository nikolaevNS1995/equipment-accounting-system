<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Role\IndexResource as RoleResource;

/**
 * @OA\Schema(
 *     schema="UserIndexResource",
 *     title="Ресурс списка пользователей",
 *     description="Формат данных брендов оборудования при получении списка",
 *     @OA\Property(property="data", type="array",
 *         @OA\Items(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="Системный блок"),
 *             @OA\Property(property="email", type="string", example="HP"),
 *             @OA\Property(property="role", type="array",
 *                 @OA\Items(ref="#/components/schemas/RoleShowResource")
 *             ),
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
            'name' => $this->name,
            'email' => $this->email,
            'role' => RoleResource::collection($this->role),
        ];
    }
}
