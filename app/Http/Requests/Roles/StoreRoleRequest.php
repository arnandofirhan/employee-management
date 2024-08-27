<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            "permissions" => "nullable|array|min:1",
        ];
    }

    public function data(): array
    {
        return [
            'name' => $this->input('name'),
            'permissions' => $this->input('permissions'),
        ];
    }
}
