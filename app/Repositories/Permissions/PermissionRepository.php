<?php

namespace App\Repositories\Permissions;

use App\Models\Permission;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

class PermissionRepository
{
    protected $app;

    public function __construct(
        Application $app,
    ) {
        $this->app = $app;
        $this->makeModel();
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
        return Permission::class;
    }

    public function query($advancedQuery = null)
    {
        $query = $this->model->query()
            ->selectRaw('
                permissions.id          AS id,
                permissions.name        AS name,
                permissions.guard_name  AS guard_name
            ');

        if ($advancedQuery) {
        }

        return $query;
    }

    public function getByPrefixGroup()
    {
        return $this->query()->get()->map(function ($query) {
            $newName = explode('.', $query->name);
            $query->role_name = ucwords(str_replace('-', ' ', $newName[0]));
            $query->name = ucwords(str_replace('-', ' ', $newName[1]));

            return $query;
        })
            ->sortBy(['role_name', 'name'])
            ->groupBy('role_name');
    }

    public function getByPrefixGroupFromRole($role)
    {
        return $role->permissions->map(function ($query) {
            $newName = explode('.', $query->name);
            $query->role_name = ucwords(str_replace('-', ' ', $newName[0]));
            $query->name = ucwords(str_replace('-', ' ', $newName[1]));

            return $query;
        })
            ->sortBy(['role_name', 'name'])
            ->groupBy('role_name')
            ->map(function ($query) {
                return $query->pluck('id');
            })
            ->toArray();
    }
}
