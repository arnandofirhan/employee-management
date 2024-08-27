<?php

namespace App\Repositories\Entities;

use App\Models\Entity;
use App\Repositories\EntityCategories\EntityCategoryRepository;
use App\Repositories\TemporaryEntities\TemporaryEntityRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;

class EntityRepository
{
    protected $app;
    protected $entityCategoryRepository;
    protected $temporaryEntityRepository;

    public function __construct(
        Application $app,
        EntityCategoryRepository $entityCategoryRepository,
        TemporaryEntityRepository $temporaryEntityRepository,
    ) {
        $this->app = $app;
        $this->makeModel();

        $this->entityCategoryRepository = $entityCategoryRepository;
        $this->temporaryEntityRepository = $temporaryEntityRepository;
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
        return Entity::class;
    }

    public function query(array $advancedQuery = []): QueryBuilder
    {
        $query =  $this->model->query()
            ->selectRaw('
                entities.id                                     AS id,
                entities.full_name                              AS full_name,
                entities.gender_category                        AS gender_category,
                entities.birth_place                            AS birth_place,
                entities.birth_date                             AS birth_date,
                entities.identity_number                        AS identity_number,
                entities.phone                                  AS phone,
                entities.identity_full_address                  AS identity_full_address,
                entities.join_date                              AS join_date,
                entities.department_id                          AS department_id,
                entities.job_placement                          AS job_placement,
                entities.employee_status_id                     AS employee_status_id,
                entities.note                                   AS note,
                entities.is_active                              AS is_active,
                IF(entities.is_active=1, "Active", "Inactive")  AS status
            ');


        if ($advancedQuery && count($advancedQuery)) {
            if (array_key_exists('full_name', $advancedQuery) && $advancedQuery['full_name']) {
                $query = $query->where('entities.full_name', 'like', '%' . $advancedQuery['full_name'] . '%');
            }

            if (array_key_exists('gender_category', $advancedQuery) && $advancedQuery['gender_category']) {
                $query = $query->where('entities.gender_category', $advancedQuery['gender_category']);
            }

            if (array_key_exists('department_ids', $advancedQuery) && $advancedQuery['department_ids']) {
                $query = $query->whereIn('entities.department_id', $advancedQuery['department_ids']);
            }

            if (array_key_exists('employee_status_ids', $advancedQuery) && $advancedQuery['employee_status_ids']) {
                $query = $query->whereIn('entities.employee_status_id', $advancedQuery['employee_status_ids']);
            }
        }

        return $query;
    }

    public function find(string $id)
    {
        return $this->model->query()->find($id);
    }

    public function findOrFail(string $id)
    {
        return $this->model->query()->findOrFail($id);
    }

    public function store(array $data)
    {
        $query = $this->model->query()->create([
            'full_name' => $data['full_name'],
            'gender_category' => $data['gender_category'],
            'birth_place' => $data['birth_place'],
            'birth_date' => $data['birth_date'],
            'identity_number' => $data['identity_number'],
            'phone' => $data['phone'],
            'identity_full_address' => $data['identity_full_address'],
            'join_date' => $data['join_date'],
            'department_id' => $data['department_id'],
            'job_placement' => $data['job_placement'],
            'employee_status_id' => $data['employee_status_id'],
            'note' => $data['note'],
            'is_active' => $data['is_active'],
        ]);

        if (array_key_exists('temporary_entity_id', $data) && $data['temporary_entity_id']) {
            $query->temporary_entity_id = $data['temporary_entity_id'];
        }
        $query->save();

        if ($data['entity_categories']) {
            $entityCategories = $this->entityCategoryRepository->query()->whereIn('id', $data['entity_categories'])->where('entity_categories.is_active', true)->get();
        } else {
            $entityCategories = $this->entityCategoryRepository->query()->whereIn('id', ['EMPLOYEE'])->where('entity_categories.is_active', true)->get();
        }
        $query->entityCategories()->sync($entityCategories);

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Entity created successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }

    public function update(string $id, array $data)
    {
        $query = $this->find($id);
        if ($query === null) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 404,
                    'message'   => 'Entity not found',
                    'errors'    => []
                ],
                'data' => $query,
            ];
        }

        $query->full_name = $data['full_name'];
        $query->gender_category = $data['gender_category'];
        $query->birth_place = $data['birth_place'];
        $query->birth_date = $data['birth_date'];
        $query->identity_number = $data['identity_number'];
        $query->phone = $data['phone'];
        $query->identity_full_address = $data['identity_full_address'];

        $query->join_date = $data['join_date'];
        $query->department_id = $data['department_id'];
        $query->job_placement = $data['job_placement'];
        $query->employee_status_id = $data['employee_status_id'];

        $query->note = $data['note'];
        $query->is_active = $data['is_active'];
        $query->save();

        if ($query->userSetting) {
            $user = $query->userSetting->user;
            $user->full_name = $query->full_name;
            $user->save();
        }

        if ($data['entity_categories']) {
            $entityCategories = $this->entityCategoryRepository->query()->whereIn('id', $data['entity_categories'])->where('entity_categories.is_active', true)->get();
        } else {
            $entityCategories = [];
        }
        $query->entityCategories()->sync($entityCategories);

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Entity updated successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }

    public function destroy(string $id): array
    {
        $query = $this->find($id);
        if ($query->userSetting) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 500,
                    'message'   => 'Entity belongs to user',
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
                'message'   => 'Entity deleted successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }

    public function import(array $data): array
    {
        $temporaryItems = $this->temporaryEntityRepository->query()
            ->where('temporary_entities.transaction_code', $data['transaction_code'])
            ->where('temporary_entities.is_validated', true)
            ->whereNotNull('temporary_entities.full_name')
            ->get();

        if ($temporaryItems->count()) {
            $insertedAmount = 0;
            foreach ($temporaryItems->toArray() as $temporaryItem) {
                $temporaryItem['temporary_project_id'] = $temporaryItem['id'];
                $temporaryItem['entity_categories'] = null;

                $res = $this->store($temporaryItem);
                if ($res['meta']['success'] === false) {
                    return [
                        'meta' => [
                            'success'   => false,
                            'code'      => 500,
                            'message'   => 'Entity imported failed',
                            'errors'    => []
                        ],
                        'data' => [],
                    ];
                }

                $insertedAmount += 1;
            }

            if ($data['amount'] == $insertedAmount) {
                return [
                    'meta' => [
                        'success'   => true,
                        'code'      => 200,
                        'message'   => 'Entity imported successfully',
                        'errors'    => []
                    ],
                    'data' => [],
                ];
            } else {
                return [
                    'meta' => [
                        'success'   => false,
                        'code'      => 500,
                        'message'   => 'Entity imported not match amount',
                        'errors'    => []
                    ],
                    'data' => [],
                ];
            }
        } else {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 500,
                    'message'   => 'Entity imported failed',
                    'errors'    => []
                ],
                'data' => [],
            ];
        }
    }
}
