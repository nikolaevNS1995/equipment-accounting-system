<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Equipment\IndexResource as EquipmentResource;
use App\Http\Resources\Furniture\IndexResource as FurnitureResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="OrderShowResource",
 *     title="Ресурс заявки",
 *     description="Формат данных заявки",
 *     @OA\Property(property="data", type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="user", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Иванов Иван"),
 *                 @OA\Property(property="email", type="string", example="ivanovi@mail.ru"),
 *         ),
 *         @OA\Property(property="order_type", type="string", example="Установка"),
 *         @OA\Property(property="status", type="string", example="В работе"),
 *         @OA\Property(property="created_at", type="date", example="2025-03-05 17:29:05"),
 *         @OA\Property(property="updated_at", type="integer", example="2025-03-05 17:29:05"),
 *         @OA\Property(property="equipment", type="array",
 *             @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="equipment_model", type="string", example="EXP-123"),
 *                 @OA\Property(property="cabinet_id", type="integer", example=1),
 *                 @OA\Property(property="inventory_number", type="integer", example=555555555),
 *             )
 *         ),
 *        @OA\Property(property="furniture", type="array",
 *            @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 * *               @OA\Property(property="furniture_type", type="string", example="Стол"),
 * *               @OA\Property(property="cabinet", type="integer", example=321),
 * *               @OA\Property(property="inventory_number", type="integer", example=55555555),
 *            )
 *        ),
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
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'order_type' => $this->order_type,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'equipment' => EquipmentResource::collection($this->equipments),
            'furniture' => FurnitureResource::collection($this->furnitures),
        ];
    }
}
