<?php

namespace App\Repositories\ShortcutLinks;

use App\Exceptions\InvalidModelException;
use App\Models\ShortcutLink;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ShortcutLinkRepository
{
    protected $app;

    public function __construct(
        Application $app,
    ) {
        $this->app = $app;
        $this->makeModel();
    }

    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new InvalidModelException($this->model());
        }

        return $this->model = $model;
    }

    public function model()
    {
        return ShortcutLink::class;
    }

    public function query(array $advancedQuery = []): QueryBuilder
    {
        $query =  $this->model->query()
            ->selectRaw('
                shortcut_links.id          AS id,
                shortcut_links.code        AS code,
                shortcut_links.target      AS target,
                shortcut_links.is_active   AS is_active
            ');

        if ($advancedQuery && count($advancedQuery)) {
            if (array_key_exists('code', $advancedQuery) && $advancedQuery['code']) {
                $query = $query->where('shortcut_links.code', $advancedQuery['code']);
            }
        }

        return $query;
    }

    public function find(string $id, array $with = [])
    {
        return $this->model->query()->with($with)->find($id);
    }

    public function findOrFail(string $id, array $with = [])
    {
        return $this->model->query()->with($with)->findOrFail($id);
    }

    public function store(array $data): array
    {
        do {
            $data['code'] = Str::random(5);
        } while ($this->query($data)->first() !== null);

        $query = $this->model->query()->create([
            'code' => $data['code'],
            'target' => $data['target'],
            'is_active' => $data['is_active'],
        ]);

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Shortcut link created successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }

    public function update(string $id, array $data): array
    {
        $query = $this->find($id);
        if ($query === null) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 404,
                    'message'   => 'Shortcut link not found',
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        $query->is_active = $data['is_active'];

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Shortcut link updated successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }

    public function destroy(string $id): array
    {
        $query = $this->find($id);
        if ($query === null) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 404,
                    'message'   => 'Shortcut link not found',
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        $query->delete();

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Shortcut link deleted successfully',
                'errors'    => []
            ],
            'data' => null,
        ];
    }
}
