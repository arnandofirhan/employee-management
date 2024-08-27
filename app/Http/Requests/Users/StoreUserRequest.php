<?php

namespace App\Http\Requests\Users;

use App\Repositories\Roles\RoleRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StoreUserRequest extends FormRequest
{
    private $roleRepository;

    public function __construct(
        RoleRepository $roleRepository
    ) {
        $this->roleRepository = $roleRepository;
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string',
            "email" => "nullable|email:rfc,dns",
            'password' => 'nullable|confirmed|min:6',
            'image' => 'nullable|file|mimes:jpeg,jpg,png',
            'status' => "nullable|boolean",
            'roles.*' => "nullable|string|exists:App\Models\Role,id",
        ];
    }

    public function data(): array
    {
        return [
            'full_name' => $this->input('full_name'),
            'username' => $this->input('email'),
            'password' => $this->getPassword(),
            'email' => $this->input('email'),
            'image_url' => $this->getImage(),
            'is_active' => $this->boolean('status'),
            'roles' => $this->getRoles(),
        ];
    }

    public function getImage(): ?string
    {
        $fileUrl = null;
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

    public function getPassword(): ?string
    {
        return $this->input('password') ? Hash::make($this->input('password')) : null;
    }

    public function getRoles()
    {
        return $this->roleRepository->query()->whereIn('roles.id', $this->input('roles') ?? [])->get();
    }
}
