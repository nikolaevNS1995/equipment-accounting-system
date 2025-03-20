<?php

namespace App\Http\Requests\CabinetType;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateCabinetTypeRequest",
 *     title="Запрос на обновление типа кабинета",
 *     description="Данные для создания нового кабинета",
 *     required={"title"},
 *     @OA\Property(property="title", type="string", example="Лаборатория"),
 * )
 */
class UpdateCabinetTypeRequest extends FormRequest
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
