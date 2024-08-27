<?php

namespace App\Http\Controllers\Departments;

use App\DataTables\Departments\DepartmentDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Departments\StoreDepartmentRequest;
use App\Http\Requests\Departments\UpdateDepartmentRequest;
use App\Repositories\Departments\DepartmentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    private $departmentRepository;

    public function __construct(
        DepartmentRepository $departmentRepository
    ) {
        $this->departmentRepository = $departmentRepository;
    }

    public function index(DepartmentDataTable $dataTable)
    {
        return $dataTable->render('contents.departments.index');
    }

    public function create(): View
    {
        return view('contents.departments.create');
    }

    public function store(StoreDepartmentRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->data();
            $res = $this->departmentRepository->store($data);
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
        $query = $this->departmentRepository->find($id);

        return view('contents.departments.edit', [
            'query' => $query,
        ]);
    }

    public function update($id, UpdateDepartmentRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->data();
            $res = $this->departmentRepository->update($id, $data);
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

            $res = $this->departmentRepository->destroy($id);
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
