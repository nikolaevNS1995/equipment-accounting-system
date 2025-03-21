<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateUserRequest",
 *     title="Запрос на обновление пользователя",
 *     description="Данные для обновления пользователя",
 *     required={"name", "email", "roles"},
 *     @OA\Property(property="name", type="string", example="Иванов Иван"),
 *     @OA\Property(property="email", type="string", example="ivanov@mail.com"),
 *     @OA\Property(property="password", type="string"),
 *     @OA\Property(property="password_confirmation", type="string"),
 *     @OA\Property(property="roles", type="array",
 *          @OA\Items(
 *              @OA\Property(property="id", type="integer", example=1),
 *          )
 *      ),
 * )
 */
class UpdateUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'nullable|string|min:6|confirmed',
            'password_confirmation' => 'nullable|string|min:6',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ];
    }
}
