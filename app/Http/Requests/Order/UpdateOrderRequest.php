<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateOrderRequest",
 *     title="Запрос на обновление заявки",
 *     description="Данные для обновления заявки",
 *     required={"user_id", "order_type", "status", "items"},
 *     @OA\Property(property="user_id", type="integer", example="HP"),
 *     @OA\Property(property="order_type", type="string", example="HP"),
 *     @OA\Property(property="status", type="string", example="HP"),
 *     @OA\Property(property="items", type="array",
 *         @OA\Items(
 *              @OA\Property(property="orderable_id", type="integer", example=1),
 *              @OA\Property(property="orderable_type", type="string", example="App\Models\Equipment"),
 *          )
 *      ),
 * )
 */
class UpdateOrderRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id',
            'order_type' => 'required|string|in:установка,перемещение,ремонт,списание',
            'status' => 'required|string|in:в ожидании,одобрено,отклонено,завершено',
            'items' => 'required|array',
            'items.*.orderable_id' => 'required|integer',
            'items.*.orderable_type' => 'required|string|in:App\Models\Equipment,App\Models\Furniture',
        ];
    }
}
