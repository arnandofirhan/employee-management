<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Requests\Auth\UpdateUserEmailRequest;
use App\Http\Requests\Auth\UpdateUserPasswordRequest;
use App\Repositories\Auth\ProfileRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProfileController extends Controller
{
    private $profileRepository;

    public function __construct(
        ProfileRepository $profileRepository,
    ) {
        $this->profileRepository = $profileRepository;
    }

    public function index(Request $request): View
    {
        return view('profile.index', [
            'query' => $request->user(),
        ]);
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'query' => $request->user(),
        ]);
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $id = $request->user()->id;
            $res = $this->profileRepository->update($id, $request->data());
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

    public function editSecurity(Request $request): View
    {
        return view('profile.edit-security', [
            'query' => $request->user(),
        ]);
    }

    public function updateEmail(UpdateUserEmailRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->profileRepository->updateEmail($request->data());
            if ($res['meta']['success'] === true) {
                DB::commit();

                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
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

    public function updatePassword(UpdateUserPasswordRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->profileRepository->updatePassword($request->data());
            if ($res['meta']['success'] === true) {
                DB::commit();

                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
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
