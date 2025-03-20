<?php

namespace App\Http\Requests\Cabinet;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateCabinetRequest",
 *     title="Запрос на изменение кабинета",
 *     description="Данные для обновления кабинета",
 *     required={"cabinet_type_id", "building_id", "title", "cabinet_number", "floor"},
 *     @OA\Property(property="cabinet_type_id", type="integer", example=1),
 *     @OA\Property(property="building_id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Лаборатория информационных технологий"),
 *     @OA\Property(property="cabinet_number", type="integer", example=321),
 *     @OA\Property(property="floor", type="integer", example=3)
 * )
 */
class UpdateCabinetRequest extends FormRequest
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
            'cabinet_type_id' => 'required|exists:cabinet_types,id',
            'building_id' => 'required|exists:buildings,id',
            'title' => 'required|string',
            'cabinet_number' => 'required|integer',
            'floor' => 'required|integer',
        ];
    }
}
