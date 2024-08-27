<?php

namespace App\Repositories\EntityCategories;

use App\Models\EntityCategory;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

class EntityCategoryRepository
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
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    public function model()
    {
        return EntityCategory::class;
    }

    public function query()
    {
        return $this->model->query()
            ->selectRaw('
                entity_categories.id                                    AS id,
                entity_categories.value                                 AS value,
                entity_categories.name                                  AS name,
                entity_categories.sequence                              AS sequence,
                entity_categories.background_color_code                 AS background_color_code,
                entity_categories.font_color_code                       AS font_color_code,
                entity_categories.is_active                             AS is_active,
                IF(entity_categories.is_active=1, "Active", "Inactive") AS status
            ')
            ->where('entity_categories.is_active', true);
    }

    public function find(string $id)
    {
        return $this->model->query()->find($id);
    }

    public function findOrFail(string $id)
    {
        return $this->model->query()->findOrFail($id);
    }

    public function update(string $id, array $data)
    {
        $query = $this->find($id);
        $query->background_color_code = $data['background_color_code'];
        $query->font_color_code = $data['font_color_code'];
        $query->save();

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Entity category updated successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }
}
