<?php

namespace App\Http\Requests\FurnitureType;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateFurnitureTypeRequest",
 *     title="Запрос на обновление типа мебели",
 *     description="Данные для обновления нового типа мебели",
 *     required={"title"},
 *     @OA\Property(property="title", type="string", example="Стол"),
 * )
 */
class UpdateFurnitureTypeRequest extends FormRequest
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
            'title' => 'string|required',
        ];
    }
}
