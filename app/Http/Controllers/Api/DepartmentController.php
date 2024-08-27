<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Departments\DepartmentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    private $departmentRepository;

    public function __construct(
        DepartmentRepository $departmentRepository
    ) {
        $this->departmentRepository = $departmentRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $data = [];
        if (auth()->user()) {
            $data = $this->departmentRepository->query()
                ->where('departments.is_active', 1)
                ->where('departments.full_name', 'like', '%' . $request->term . '%')
                ->orderBy('full_name')
                ->take(50)
                ->get();
        }

        return response()->json([
            'meta' => [
                'success'   => false,
                'code'      => 200,
                'message'   => '',
                'errors'    => []
            ],
            'data' => $data,
        ]);
    }
}
