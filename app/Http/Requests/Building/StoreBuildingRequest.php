<?php

namespace App\Http\Requests\Building;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreBuildingRequest",
 *     title="Запрос на создание площадки",
 *     description="Данные для создания новой площадки",
 *     required={"title", "address", "floor"},
 *     @OA\Property(property="title", type="string", example="Анадырский"),
 *     @OA\Property(property="address", type="string", example="Москва, Анадырский проезд, 79"),
 *     @OA\Property(property="floor", type="integer", example=3)
 * )
 */
class StoreBuildingRequest extends FormRequest
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
            'address' => 'required|string',
            'floor' => 'required|integer',
        ];
    }
}
