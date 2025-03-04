<?php

namespace App\Http\Requests\EquipmentBrand;

use Illuminate\Foundation\Http\FormRequest;

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
