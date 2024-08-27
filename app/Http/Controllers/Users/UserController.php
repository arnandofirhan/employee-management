<?php

namespace App\Http\Controllers\Users;

use App\DataTables\Users\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\DeleteUserRequest;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserEmailRequest;
use App\Http\Requests\Users\UpdateUserPasswordRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Requests\Users\UpdateUserRoleRequest;
use App\Http\Requests\Users\UpdateUserSettingRequest;
use App\Repositories\Roles\RoleRepository;
use App\Repositories\Users\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends Controller
{
    private $userRepository;
    private $roleRepository;

    public function __construct(
        RoleRepository $roleRepository,
        UserRepository $userRepository
    ) {
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
    }

    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('contents.users.index');
    }

    public function create(): View
    {
        $roles = $this->roleRepository->query()->get();

        return view('contents.users.create', [
            'roles' => $roles,
        ]);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->data();
            $res = $this->userRepository->store($data);
            if ($res['meta']['success'] === true) {
                DB::commit();
            } else {
                DB::rollback();
            }
        } catch (\Exception $e) {
            DB::rollback();

            if ($data['image_url']) {
                $this->userRepository->removeImage($data['image_url']);
            }

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
        $query = $this->userRepository->find($id);

        return view('contents.users.show', [
            'query' => $query,
        ]);
    }

    public function edit($id): View
    {
        $query = $this->userRepository->find($id);

        return view('contents.users.edit', [
            'query' => $query,
        ]);
    }

    public function update($id, UpdateUserRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->data();
            $res = $this->userRepository->update($id, $data);
            if ($res['meta']['success'] === true) {
                DB::commit();
            } else {
                DB::rollback();
            }
        } catch (\Exception $e) {
            DB::rollback();

            if ($data['image_url']) {
                $this->userRepository->removeImage($data['image_url']);
            }

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

    public function editSecurity($id): View
    {
        $query = $this->userRepository->find($id);

        return view('contents.users.edit-security', [
            'query' => $query,
        ]);
    }

    public function updateEmail($id, UpdateUserEmailRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->userRepository->updateEmail($id, $request->data());
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

    public function updatePassword($id, UpdateUserPasswordRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->userRepository->updatePassword($id, $request->data());
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

    public function editRole($id): View
    {
        $query = $this->userRepository->find($id);
        $roles = $this->roleRepository->query()->get();

        return view('contents.users.edit-role', [
            'query' => $query,
            'roles' => $roles,
        ]);
    }

    public function updateRole($id, UpdateUserRoleRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->userRepository->updateRole($id, $request->data());
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

    public function editSetting($id): View
    {
        $query = $this->userRepository->find($id);

        return view('contents.users.edit-setting', [
            'query' => $query,
        ]);
    }

    public function updateSetting($id, UpdateUserSettingRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->userRepository->updateSetting($id, $request->data());
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

    public function destroy($id, DeleteUserRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->userRepository->destroy($id, $request->data());
            if ($res['meta']['success'] === true) {
                DB::commit();

                if ($id == auth()->user()->id) {
                    auth()->logout();

                    session()->invalidate();
                    session()->regenerateToken();
                }
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
