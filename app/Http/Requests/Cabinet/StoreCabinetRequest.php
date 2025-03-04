<?php

namespace App\Http\Requests\Cabinet;

use Illuminate\Foundation\Http\FormRequest;

class StoreCabinetRequest extends FormRequest
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
