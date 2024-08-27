<?php

namespace App\Http\Requests\EntityCategories;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEntityCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'background_color_code' => 'required|string',
            'font_color_code' => 'required|string',
        ];
    }

    public function data(): array
    {
        return [
            'background_color_code' => $this->input('background_color_code'),
            'font_color_code' => $this->input('font_color_code'),
        ];
    }
}
