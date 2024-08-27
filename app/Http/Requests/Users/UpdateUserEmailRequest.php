<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'lowercase', 'email:rfc,dns'],
        ];
    }

    public function data(): array
    {
        return [
            'email' => $this->input('email'),
        ];
    }
}
