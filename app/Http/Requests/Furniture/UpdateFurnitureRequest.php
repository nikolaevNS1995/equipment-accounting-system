<?php

namespace App\Http\Requests\Furniture;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateFurnitureRequest",
 *     title="Запрос на обновление мебели",
 *     description="Данные для обновления мебели",
 *     required={"furniture_type_id", "cabinet_id", "inventory_number"},
 *     @OA\Property(property="furniture_type_id", type="integer", example=1),
 *     @OA\Property(property="cabinet_id", type="integer", example=1),
 *     @OA\Property(property="inventory_number", type="integer", example=5555555),
 * )
 */
class UpdateFurnitureRequest extends FormRequest
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
            'furniture_type_id' => 'required|exists:furniture_types,id',
            'cabinet_id' => 'required|exists:cabinets,id',
            'inventory_number' => 'required|integer',
        ];
    }
}
