<?php

namespace App\Http\Controllers\EntityCategories;

use App\DataTables\EntityCategories\EntityCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\EntityCategories\UpdateEntityCategoryRequest;
use App\Repositories\EntityCategories\EntityCategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EntityCategoryController extends Controller
{
    private $entityCategoryRepository;

    public function __construct(
        EntityCategoryRepository $entityCategoryRepository
    ) {
        $this->entityCategoryRepository = $entityCategoryRepository;
    }

    public function index(EntityCategoryDataTable $dataTable)
    {
        return $dataTable->render('contents.entity-categories.index');
    }

    public function edit($id): View
    {
        $query = $this->entityCategoryRepository->find($id);

        return view('contents.entity-categories.edit', [
            'query' => $query,
        ]);
    }

    public function update($id, UpdateEntityCategoryRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->entityCategoryRepository->update($id, $request->data());
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
