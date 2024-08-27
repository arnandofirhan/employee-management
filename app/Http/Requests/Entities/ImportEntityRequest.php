<?php

namespace App\Http\Requests\Entities;

use Illuminate\Foundation\Http\FormRequest;

class ImportEntityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "transaction_code" => "required|string|exists:App\Models\TemporaryEntity,transaction_code",
            "amount" => "required|numeric",
        ];
    }

    public function data(): array
    {
        return [
            'transaction_code' => $this->input('transaction_code'),
            'amount' => $this->input('amount'),
        ];
    }
}
