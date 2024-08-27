<?php

namespace App\Repositories\Roles;

use App\Models\Role;
use App\Repositories\Permissions\PermissionRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

class RoleRepository
{
    protected $app;
    private $permissionRepository;

    public function __construct(
        Application $app,

        PermissionRepository $permissionRepository,
    ) {
        $this->app = $app;
        $this->makeModel();

        $this->permissionRepository = $permissionRepository;
    }

    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    public function model()
    {
        return Role::class;
    }

    public function query($advancedQuery = null)
    {
        $query = $this->model->query()
            ->selectRaw('
                roles.id            AS id,
                roles.name          AS name,
                roles.guard_name    AS guard_name
            ');
        if (auth()->user()->hasRole('Main') === false) {
            $query = $query->where('roles.name', '!=', 'Main');
        }

        if ($advancedQuery) {
        }

        return $query;
    }

    public function find(string $id, $with = [])
    {
        return $this->model->query()->with($with)->find($id);
    }

    public function findOrFail(string $id, $with = [])
    {
        return $this->model->query()->with($with)->findOrFail($id);
    }

    public function store(array $data)
    {
        $query = $this->model->query()
            ->whereName($data['name'])
            ->first();
        if ($query) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 409,
                    'message'   => 'Role is already exists',
                    'errors'    => []
                ],
                'data' => null,
            ];
        } else {
            $query = $this->model->query()
                ->create([
                    'name' => $data['name'],
                ]);
        }

        $permissions = $this->permissionRepository->query()->whereIn('permissions.id', $data['permissions'])->get();
        if ($permissions->count()) {
            $query->syncPermissions($permissions);
        }

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Role created successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }

    public function update(string $id, array $data)
    {
        $query = $this->model->query()
            ->where('roles.name', $data['name'])
            ->whereNot('roles.id', $id)
            ->first();
        if ($query) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 409,
                    'message'   => 'Role is already exists',
                    'errors'    => []
                ],
                'data' => [],
            ];
        }

        $query = $this->find($id);
        $query->name = $data['name'];
        $query->save();

        $permissions = $this->permissionRepository->query()->whereIn('permissions.id', $data['permissions'])->get();
        if ($permissions->count()) {
            $query->syncPermissions($permissions);
        }

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Role updated successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }

    public function destroy(string $id): array
    {
        $query = $this->find($id);
        if ($query->users->count()) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 409,
                    'message'   => 'You cannot delete this data',
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        $query->syncPermissions([]);
        $query->delete();

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Role deleted successfully',
                'errors'    => []
            ],
            'data' => null,
        ];
    }
}
