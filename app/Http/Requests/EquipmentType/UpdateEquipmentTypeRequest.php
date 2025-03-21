<?php

namespace App\Http\Requests\EquipmentType;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateEquipmentTypeRequest",
 *     title="Запрос на обновление типа оборудования",
 *     description="Данные для обновления типа оборудования",
 *     required={"title"},
 *     @OA\Property(property="title", type="string", example="HP"),
 * )
 */
class UpdateEquipmentTypeRequest extends FormRequest
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
            'title' => 'required|string',
        ];
    }
}
