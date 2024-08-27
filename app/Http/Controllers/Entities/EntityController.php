<?php

namespace App\Http\Controllers\Entities;

use App\DataTables\Entities\EntityDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Entities\ImportEntityRequest;
use App\Http\Requests\Entities\StoreEntityRequest;
use App\Http\Requests\Entities\UpdateEntityRequest;
use App\Http\Requests\Entities\ValidateEntityRequest;
use App\Imports\Entities\EntityImport;
use App\Repositories\Departments\DepartmentRepository;
use App\Repositories\EmployeeStatuses\EmployeeStatusRepository;
use App\Repositories\Entities\EntityRepository;
use App\Repositories\EntityCategories\EntityCategoryRepository;
use App\Repositories\TemporaryEntities\TemporaryEntityRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class EntityController extends Controller
{
    private $departmentRepository;
    private $employeeStatusRepository;
    private $entityCategoryRepository;
    private $entityRepository;
    private $temporaryEntityRepository;

    public function __construct(
        DepartmentRepository $departmentRepository,
        EmployeeStatusRepository $employeeStatusRepository,
        EntityCategoryRepository $entityCategoryRepository,
        EntityRepository $entityRepository,
        TemporaryEntityRepository $temporaryEntityRepository,
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->employeeStatusRepository = $employeeStatusRepository;
        $this->entityCategoryRepository = $entityCategoryRepository;
        $this->entityRepository = $entityRepository;
        $this->temporaryEntityRepository = $temporaryEntityRepository;
    }

    public function index(EntityDataTable $dataTable)
    {
        $departments = $this->departmentRepository->query()->where('departments.is_active', true)->orderBy('departments.full_name')->get();
        $employeeStatuses = $this->employeeStatusRepository->query()->where('employee_statuses.is_active', true)->orderBy('employee_statuses.name')->get();

        return $dataTable->render('contents.entities.index', [
            'departments' => $departments,
            'employeeStatuses' => $employeeStatuses,
        ]);
    }

    public function create(): View
    {
        $employeeStatuses = $this->employeeStatusRepository->query()->where('employee_statuses.is_active', true)->orderBy('employee_statuses.name')->get();
        $entityCategories = $this->entityCategoryRepository->query()->where('entity_categories.is_active', true)->orderBy('entity_categories.sequence')->get();

        return view('contents.entities.create', [
            'employeeStatuses' => $employeeStatuses,
            'entityCategories' => $entityCategories,
        ]);
    }

    public function store(StoreEntityRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->entityRepository->store($request->data());
            if ($res['meta']['success'] === true) {
                DB::commit();
            } else {
                DB::rollback();
            }
        } catch (\Exception $e) {
            DB::rollback();

            $res = [
                'meta' => [
                    'success'   => false,
                    'code'      => \App\Constants\StatusCodeConstant::label($e->getCode()) ? $e->getCode() : 500,
                    'message'   => $e->getMessage(),
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        return response()->json($res, $res['meta']['code']);
    }

    public function edit($id): View
    {
        $query = $this->entityRepository->find($id);
        $employeeStatuses = $this->employeeStatusRepository->query()->where('employee_statuses.is_active', true)->orderBy('employee_statuses.name')->get();
        $entityCategories = $this->entityCategoryRepository->query()->where('entity_categories.is_active', true)->orderBy('entity_categories.sequence')->get();

        return view('contents.entities.edit', [
            'query' => $query,
            'employeeStatuses' => $employeeStatuses,
            'entityCategories' => $entityCategories,
        ]);
    }

    public function update($id, UpdateEntityRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->entityRepository->update($id, $request->data());
            if ($res['meta']['success'] === true) {
                DB::commit();
            } else {
                DB::rollback();
            }
        } catch (\Exception $e) {
            DB::rollback();

            $res = [
                'meta' => [
                    'success'   => false,
                    'code'      => \App\Constants\StatusCodeConstant::label($e->getCode()) ? $e->getCode() : 500,
                    'message'   => $e->getMessage(),
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        return response()->json($res, $res['meta']['code']);
    }

    public function destroy($id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->entityRepository->destroy($id);
            if ($res['meta']['success'] === true) {
                DB::commit();
            } else {
                DB::rollback();
            }
        } catch (\Exception $e) {
            DB::rollback();

            $res = [
                'meta' => [
                    'success'   => false,
                    'code'      => \App\Constants\StatusCodeConstant::label($e->getCode()) ? $e->getCode() : 500,
                    'message'   => $e->getMessage(),
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        return response()->json($res, $res['meta']['code']);
    }

    public function import(): View
    {
        return view('contents.entities.import');
    }

    public function validateImport(ValidateEntityRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = Excel::toCollection(new EntityImport, $request->file);
            if ($data->count()) {
                $res = $this->temporaryEntityRepository->manyStore($data[0]->toArray());
                if ($res['meta']['success'] === true) {
                    DB::commit();
                } else {
                    DB::rollback();
                }
            } else {
                DB::rollback();

                $res = [
                    'meta' => [
                        'success'   => false,
                        'code'      => 500,
                        'message'   => 'Import reference entities validated failed',
                        'errors'    => []
                    ],
                    'data' => [],
                ];
            }
        } catch (\Exception $e) {
            DB::rollback();

            $res = [
                'meta' => [
                    'success'   => false,
                    'code'      => \App\Constants\StatusCodeConstant::label($e->getCode()) ? $e->getCode() : 500,
                    'message'   => $e->getMessage(),
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        return response()->json($res, $res['meta']['code']);
    }

    public function storeImport(ImportEntityRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->entityRepository->import($request->data());
            if ($res['meta']['success'] === true) {
                DB::commit();
            } else {
                DB::rollback();
            }
        } catch (\Exception $e) {
            DB::rollback();

            $res = [
                'meta' => [
                    'success'   => false,
                    'code'      => \App\Constants\StatusCodeConstant::label($e->getCode()) ? $e->getCode() : 500,
                    'message'   => $e->getMessage(),
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        return response()->json($res, $res['meta']['code']);
    }
}
