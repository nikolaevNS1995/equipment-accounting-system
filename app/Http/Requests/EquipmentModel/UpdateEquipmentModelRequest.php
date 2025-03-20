<?php

namespace App\Http\Requests\EquipmentModel;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateEquipmentModelRequest",
 *     title="Запрос на обновление модели оборудования",
 *     description="Данные для обновления модели оборудования",
 *     required={"title", "equipment_brand_id"},
 *     @OA\Property(property="equipment_brand_id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="EXP-123"),
 * )
 */
class UpdateEquipmentModelRequest extends FormRequest
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
            'equipment_brand_id' => 'required|exists:equipment_brands,id',
            'title' => 'required|string',
        ];
    }
}
