<?php

namespace App\Http\Requests\Entities;

use Illuminate\Foundation\Http\FormRequest;

class AdvancedSearchEntityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'nullable|string',
            'gender_category' => 'nullable|string',
            'departments' => 'nullable|string',
            'employee_statuses' => 'nullable|string',
        ];
    }

    public function data(): array
    {
        return [
            'full_name' => $this->input('full_name'),
            'gender_category' => $this->input('gender_category'),
            'department_ids' => $this->getIds('departments'),
            'employee_status_ids' => $this->getIds('employee_statuses'),
        ];
    }

    public function getIds($parameter): array
    {
        return $this->input($parameter) ? explode(',', $this->input($parameter)) : [];
    }
}
