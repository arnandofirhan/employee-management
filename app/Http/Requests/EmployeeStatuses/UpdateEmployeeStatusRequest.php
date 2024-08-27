<?php

namespace App\Http\Requests\EmployeeStatuses;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            "status" => "nullable|boolean",
        ];
    }

    public function data(): array
    {
        return [
            'name' => $this->input('name'),
            'is_active' => $this->boolean('status'),
        ];
    }
}
