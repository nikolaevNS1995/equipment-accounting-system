<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Equipment\IndexResource as EquipmentResource;
use App\Http\Resources\Furniture\IndexResource as FurnitureResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
