<?php

namespace App\Http\Requests\Equipment;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreEquipmentRequest",
 *     title="Запрос на создание оборудования",
 *     description="Данные для создания нового оборудования",
 *     required={"equipment_model_id", "cabinet_id", "inventory_number"},
 *     @OA\Property(property="equipment_model_id", type="integer", example=1),
 *     @OA\Property(property="cabinet_id", type="integer", example=1),
 *     @OA\Property(property="inventory_number", type="integer", example=55555555),
 * )
 */
class StoreEquipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'equipment_model_id' => 'required|exists:equipment_models,id',
            'cabinet_id' => 'required|exists:cabinets,id',
            'inventory_number' => 'required|integer',
        ];
    }
}
