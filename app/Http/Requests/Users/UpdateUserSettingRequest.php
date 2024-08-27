<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "entity" => "nullable|string|exists:App\Models\Entity,id",
        ];
    }

    public function data(): array
    {
        return [
            'entity_id' => $this->input('entity'),
        ];
    }
}
