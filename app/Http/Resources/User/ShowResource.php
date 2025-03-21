<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Role\IndexResource as RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="UserShowResource",
 *     title="Ресурс пользователя",
 *     description="Формат данных пользователя",
 *     @OA\Property(property="data", type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="name", type="string", example="Иванов Иван"),
 *         @OA\Property(property="email", type="string", example="ivanovi@mail.ru"),
 *         @OA\Property(property="role", type="array",
 *             @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="title", type="string", example="Инженер"),
 *             )
 *         ),
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
            'name' => $this->name,
            'email' => $this->email,
            'role' => RoleResource::collection($this->role),
        ];
    }
}
