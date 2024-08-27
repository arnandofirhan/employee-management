<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class DeleteUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // "is_deactivated" => "nullable|boolean",
        ];
    }

    public function data(): array
    {
        return [
            // 'is_deactivated' => $this->boolean('is_deactivated'),
        ];
    }
}
