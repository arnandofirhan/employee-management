<?php

namespace App\Http\Controllers\Roles;

use App\DataTables\Roles\RoleDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use App\Repositories\Permissions\PermissionRepository;
use App\Repositories\Roles\RoleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RoleController extends Controller
{
    private $permissionRepository;
    private $roleRepository;

    public function __construct(
        PermissionRepository $permissionRepository,
        RoleRepository $roleRepository
    ) {
        $this->permissionRepository = $permissionRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index(RoleDataTable $dataTable)
    {
        return $dataTable->render('contents.roles.index');
    }

    public function create(): View
    {
        $permissions = $this->permissionRepository->getByPrefixGroup();

        return view('contents.roles.create', [
            'permissions' => $permissions,
        ]);
    }

    public function store(StoreRoleRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->roleRepository->store($request->data());
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

    public function show($id): View
    {
        $query = $this->roleRepository->find($id);

        return view('contents.roles.show', [
            'query' => $query,
        ]);
    }

    public function edit($id): View
    {
        $query = $this->roleRepository->find($id);
        $permissions = $this->permissionRepository->getByPrefixGroup();
        $rolePermissionIds = $this->permissionRepository->getByPrefixGroupFromRole($query);

        return view('contents.roles.edit', [
            'query' => $query,
            'permissions' => $permissions,
            'rolePermissionIds' => $rolePermissionIds
        ]);
    }

    public function update($id, UpdateRoleRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->roleRepository->update($id, $request->data());
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

            $res = $this->roleRepository->destroy($id);
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
