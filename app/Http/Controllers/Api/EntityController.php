<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Entities\EntityRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    private $entityRepository;

    public function __construct(
        EntityRepository $entityRepository
    ) {
        $this->entityRepository = $entityRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $data = [];
        if (auth()->user()) {
            $data = $this->entityRepository->query()
                ->where('entities.is_active', 1)
                ->where('entities.full_name', 'like', '%' . $request->term . '%')
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
