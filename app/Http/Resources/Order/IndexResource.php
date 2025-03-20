<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="OrderIndexResource",
 *     title="Ресурс списка заявки",
 *     description="Формат данных заявки при получении списка",
 *     @OA\Property(property="data", type="array",
 *         @OA\Items(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="user", type="string", example="Иванов Иван"),
 *             @OA\Property(property="order_type", type="string", example="В работе"),
 *             @OA\Property(property="status", type="string", example="Новый"),
 *             @OA\Property(property="created_at", type="date", example="Y-m-d H:i:s"),
 *             @OA\Property(property="updated_at", type="date", example="Y-m-d H:i:s"),
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
            'user' =>  $this->user->name,
            'order_type' => $this->order_type,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
