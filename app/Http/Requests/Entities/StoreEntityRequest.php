<?php

namespace App\Http\Requests\Entities;

use App\Constants\GenderCategoryConstant;
use Illuminate\Foundation\Http\FormRequest;

class StoreEntityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string',
            'gender_category' => 'required|string|in:' . implode(',', GenderCategoryConstant::texts()),
            'birth_place' => 'required|string',
            'birth_date' => 'nullable|date_format:"Y-m-d"',
            'identity_number' => 'nullable|numeric|digits:16',
            'phone' => 'nullable|numeric|digits_between:1,13',
            'identity_full_address' => 'required|string',
            'join_date' => 'required|string',
            'department' => 'required|string|exists:App\Models\Department,id',
            'job_placement' => 'required|string',
            'employee_status' => 'required|string|exists:App\Models\EmployeeStatus,id',
            'note' => 'nullable|string',
            "status" => "nullable|boolean",
            'entity_categories' => 'nullable|array',
            'entity_categories.*' => 'nullable|string|exists:App\Models\EntityCategory,id',
        ];
    }

    public function data(): array
    {
        return [
            'full_name' => $this->input('full_name'),
            'gender_category' => $this->input('gender_category'),
            'birth_place' => $this->input('birth_place'),
            'birth_date' => $this->input('birth_date'),
            'identity_number' => $this->input('identity_number'),
            'phone' => $this->input('phone'),
            'identity_full_address' => $this->input('identity_full_address'),
            'join_date' => $this->input('join_date'),
            'department_id' => $this->input('department'),
            'job_placement' => $this->input('job_placement'),
            'employee_status_id' => $this->input('employee_status'),
            'note' => $this->input('note'),
            'is_active' => $this->boolean('status'),
            'entity_categories' => $this->input('entity_categories'),
        ];
    }
}
