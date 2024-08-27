<?php

namespace App\Http\Requests\Users;

use App\Repositories\Roles\RoleRepository;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRoleRequest extends FormRequest
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
            "roles.*" => "nullable|string|exists:App\Models\Role,id",
        ];
    }

    public function data(): array
    {
        return [
            'roles' => $this->getRoles(),
        ];
    }

    public function getRoles()
    {
        return $this->roleRepository->query()->whereIn('roles.id', $this->input('roles') ?? [])->get();
    }
}
