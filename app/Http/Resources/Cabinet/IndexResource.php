<?php

namespace App\Http\Resources\Cabinet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'cabinet_type' => $this->cabinetType->title,
            'building' => $this->building->title,
            'title' => $this->title,
            'cabinet_number' => $this->cabinet_number,
            'floor' => $this->floor,
        ];
    }
}
