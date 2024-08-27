<?php

namespace App\Http\Controllers\EmployeeStatuses;

use App\DataTables\EmployeeStatuses\EmployeeStatusDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeStatuses\StoreEmployeeStatusRequest;
use App\Http\Requests\EmployeeStatuses\UpdateEmployeeStatusRequest;
use App\Repositories\EmployeeStatuses\EmployeeStatusRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EmployeeStatusController extends Controller
{
    private $employeeStatusRepository;

    public function __construct(
        EmployeeStatusRepository $employeeStatusRepository
    ) {
        $this->employeeStatusRepository = $employeeStatusRepository;
    }

    public function index(EmployeeStatusDataTable $dataTable)
    {
        return $dataTable->render('contents.employee-statuses.index');
    }

    public function create(): View
    {
        return view('contents.employee-statuses.create');
    }

    public function store(StoreEmployeeStatusRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->data();
            $res = $this->employeeStatusRepository->store($data);
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
        $query = $this->employeeStatusRepository->find($id);

        return view('contents.employee-statuses.edit', [
            'query' => $query,
        ]);
    }

    public function update($id, UpdateEmployeeStatusRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->data();
            $res = $this->employeeStatusRepository->update($id, $data);
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

            $res = $this->employeeStatusRepository->destroy($id);
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
