<?php

namespace App\Http\Requests\Departments;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string',
            "status" => "nullable|boolean",
        ];
    }

    public function data(): array
    {
        return [
            'full_name' => $this->input('full_name'),
            'is_active' => $this->boolean('status'),
        ];
    }
}
