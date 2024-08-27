<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => "required|string",
            'image' => 'nullable|file|mimes:jpeg,jpg,png',
            "is_image_removed" => "nullable|boolean",
            'status' => "nullable|boolean",
        ];
    }

    public function data(): array
    {
        return [
            'full_name' => $this->input('full_name'),
            'image_url' => $this->getImage(),
            'is_image_removed' => $this->boolean('is_image_removed'),
            'is_active' => $this->boolean('status'),
        ];
    }

    public function getImage(): string
    {
        $fileUrl = '';
        $fileDirectory = 'user-images';
        if ($this->hasFile('image')) {
            $file          = $this->file('image');
            do {
                $fileName      = date('Y_m_d_His_') . $file->hashName();
            } while (Storage::disk('public')->exists($fileDirectory . '/' . $fileName));
            $fileUrl    = $file->storeAs($fileDirectory, $fileName, 'public');
        }

        return $fileUrl;
    }
}
