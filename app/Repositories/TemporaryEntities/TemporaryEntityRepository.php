<?php

namespace App\Repositories\TemporaryEntities;

use App\Models\TemporaryEntity;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TemporaryEntityRepository
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
        return TemporaryEntity::class;
    }

    public function query($advancedQuery = null)
    {
        $query = $this->model->query()
            ->selectRaw('
                temporary_entities.id                                       AS id,
                temporary_entities.full_name                                AS full_name,
                temporary_entities.gender_category                          AS gender_category,
                temporary_entities.birth_place                              AS birth_place,
                temporary_entities.birth_date                               AS birth_date,

                temporary_entities.identity_number                          AS identity_number,
                temporary_entities.phone                                    AS phone,
                temporary_entities.identity_full_address                    AS identity_full_address,

                temporary_entities.join_date                                AS join_date,
                temporary_entities.department_id                            AS department_id,
                temporary_entities.job_placement                            AS job_placement,
                temporary_entities.employee_status_id                       AS employee_status_id,

                temporary_entities.note                                     AS note,
                temporary_entities.is_active                                AS is_active,
                IF(temporary_entities.is_active=1, "Active", "Inactive")    AS status,

                temporary_entities.is_validated     AS is_validated,
                temporary_entities.note             AS note
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
                'transaction_code' => $data['transaction_code'] ?? null,

                'full_name' => $data['full_name'] ?? null,
                'gender_category' => $data['gender_category'] ?? null,
                'birth_place' => $data['birth_place'] ?? null,
                'birth_date' => $data['birth_date'] ?? null,

                'identity_number' => $data['identity_number'] ?? null,
                'phone' => $data['phone'] ?? null,
                'identity_full_address' => $data['identity_full_address'] ?? null,

                'join_date' => $data['join_date'] ?? null,
                'department_id' => $data['department_id']  ?? null,
                'job_placement' => $data['job_placement']  ?? null,
                'employee_status_id' => $data['employee_status_id']  ?? null,

                'note' => $data['note'] ?? null,
                'is_active' => $data['is_active'] === true,

                'is_validated' => $data['is_validated'] === true,
                'notes' => json_encode($data['notes'], true),
            ]);

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Temporary entity created successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }

    public function manyStore(array $data): array
    {
        $transactionCode = null;
        $trueAmount = $falseAmount = 0;
        if (count($data)) {
            $transactionCode = (string) Str::uuid();
            foreach ($data as $item) {
                $item['transaction_code'] = $transactionCode;
                $res = $this->store($item);
                if ($res["meta"]["success"] === false) {
                    return [
                        'meta' => [
                            'success'   => false,
                            'code'      => 500,
                            'message'   => 'Temporary entity imported failed',
                            'errors'    => []
                        ],
                        'data' => [],
                    ];
                }

                if ($item['is_validated'] == 'true') {
                    $trueAmount += 1;
                } else {
                    $falseAmount += 1;
                }
            }
        }

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Temporary entity imported successfully',
                'errors'    => []
            ],
            'data' => [
                'transaction_code' => $transactionCode,
                'true_amount' => $trueAmount,
                'false_amount' => $falseAmount,
                'total_amount' => $trueAmount + $falseAmount,
                'data' => $data,
            ],
        ];
    }
}
