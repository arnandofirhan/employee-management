<?php

namespace App\Repositories\EmployeeStatuses;

use App\Models\EmployeeStatus;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

class EmployeeStatusRepository
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
        return EmployeeStatus::class;
    }

    public function query($advancedQuery = null)
    {
        $query = $this->model->query()
            ->selectRaw('
                employee_statuses.id                                      AS id,
                employee_statuses.name                                    AS name,
                employee_statuses.is_active                               AS is_active,
                IF(employee_statuses.is_active=1, "Active", "Inactive")   AS status
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
                'name' => $data['name'],
                'is_active' => $data['is_active'],
            ]);

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Employee status created successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }

    public function update(string $id, array $data)
    {
        $query = $this->find($id);
        $query->name = $data['name'];
        $query->is_active = $data['is_active'];
        $query->save();

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Employee status updated successfully',
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
                    'message'   => 'Employee status not found',
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
                    'message'   => 'There are entities who have this employee status',
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
                'message'   => 'Employee status deleted successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }
}
