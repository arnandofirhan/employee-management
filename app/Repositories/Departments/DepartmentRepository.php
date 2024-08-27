<?php

namespace App\Repositories\Departments;

use App\Models\Department;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

class DepartmentRepository
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
        return Department::class;
    }

    public function query($advancedQuery = null)
    {
        $query = $this->model->query()
            ->selectRaw('
                departments.id                                      AS id,
                departments.full_name                               AS full_name,
                departments.is_active                               AS is_active,
                IF(departments.is_active=1, "Active", "Inactive")   AS status
            ');

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
            ->create([
                'full_name' => $data['full_name'],
                'is_active' => $data['is_active'],
            ]);

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Department created successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }

    public function update(string $id, array $data)
    {
        $query = $this->find($id);
        $query->full_name = $data['full_name'];
        $query->is_active = $data['is_active'];
        $query->save();

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Department updated successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }

    public function destroy(string $id): array
    {
        $query = $this->find($id);
        if ($query === null) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 404,
                    'message'   => 'Department not found',
                    'errors'    => []
                ],
                'data' => $query,
            ];
        }

        if ($query->entities?->count()) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 403,
                    'message'   => 'There are entities who have this department',
                    'errors'    => []
                ],
                'data' => $query,
            ];
        }

        $query->delete();

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Department deleted successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }
}
