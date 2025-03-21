<?php

namespace App\Http\Requests\EquipmentBrand;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreEquipmentBrandRequest",
 *     title="Запрос на создание бренда оборудования",
 *     description="Данные для создания нового бренда оборудования",
 *     required={"equipment_type_id", "title"},
 *     @OA\Property(property="equipment_type_id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="HP"),
 * )
 */
class StoreEquipmentBrandRequest extends FormRequest
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
            'equipment_type_id' => 'required|exists:equipment_types,id',
            'title' => 'required|string',
        ];
    }
}
