<?php

namespace App\Http\Requests\Entities;

use Illuminate\Foundation\Http\FormRequest;

class ValidateEntityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => "required|file|mimes:csv,xls,xlsx",
        ];
    }

    public function data(): array
    {
        return [
            'file' => $this->input('file'),
        ];
    }
}
