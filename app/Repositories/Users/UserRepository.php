<?php

namespace App\Repositories\Users;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use App\Models\User;
use App\Repositories\Entities\EntityRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

class UserRepository
{
    protected $app;
    private $entityRepository;

    public function __construct(
        Application $app,

        EntityRepository $entityRepository,
    ) {
        $this->app = $app;
        $this->makeModel();

        $this->entityRepository = $entityRepository;
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
        return User::class;
    }

    public function query($advancedQuery = null): QueryBuilder
    {
        $query = $this->model->query()
            ->selectRaw('
                users.id                            AS id,
                users.full_name                     AS full_name,
                users.email                         AS email,
                users.image_url                     AS image_url,
                users.is_active                     AS is_active,
                IF(users.is_active=1, "Active", "Inactive") AS status
            ');

        if (auth()->user()->hasRole('Main') === false) {
            $query = $query
                ->whereDoesntHave('roles', function ($query) {
                    return $query->where('name', 'Main');
                });
        }

        if ($advancedQuery) {
        }

        return $query;
    }

    public function find(string $id, $with = [])
    {
        return $this->model->query()->with($with)->find($id);
    }

    public function findOrFail(string $id, $with = [])
    {
        return $this->model->query()->with($with)->findOrFail($id);
    }

    public function store(array $data): array
    {
        $query = $this->model->query()->whereEmail($data['email'])->first();
        if ($query) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 409,
                    'message'   => 'This email is already registered',
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        $query = $this->model->query()
            ->create([
                'full_name' => $data['full_name'],
                'username' => $data['username'],
                'password' => $data['password'],
                "email" => $data['email'],
                'image_url' => $data['image_url'],

                'email_verified_at' => now(),
                'is_active' => $data['is_active'],
            ]);

        $query->syncRoles($data['roles']);

        // $res = $this->entityRepository->store([
        //     'full_name' => $data['full_name'],
        // ]);
        // if ($res['meta']['success'] === true) {
        //     $entity = $res['data'];
        // } else {
        //     return $res;
        // }

        // $userSetting = $query->userSetting()->updateOrCreate([
        //     'user_id' => $query->id,
        // ], [
        //     'entity_id' => $entity->id,
        // ]);

        return [
            'meta' => [
                'success'   => true,
                'code'      => 201,
                'message'   => 'User created successfully',
                'errors'    => []
            ],
            'data' => null,
        ];
    }

    public function update(string $id, array $data): array
    {
        $query = $this->find($id);
        if ($data['is_image_removed'] === false) {
            if ($data['image_url']) {
                $query->image_url = $data['image_url'];
            }
        } else {
            $query->image_url = null;
        }

        $query->full_name   = $data['full_name'];
        $query->is_active   = $data['is_active'];
        $query->save();

        if ($query->userSetting) {
            $entity = $query->userSetting->entity;
            if ($entity) {
                $entity->full_name = $query->full_name;
                $entity->is_active = $query->is_active;
                $entity->save();
            }
        }

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'User updated successfully',
                'errors'    => []
            ],
            'data' => null,
        ];
    }

    public function updateEmail(string $id, array $data): array
    {
        $query = $this->find($id);
        if ($query === null) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 404,
                    'message'   => 'User not found',
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        $query->username    = $data['email'];
        $query->email       = $data['email'];
        $query->save();

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Email updated successfully',
                'errors'    => []
            ],
            'data' => null,
        ];
    }

    public function updatePassword(string $id, array $data): array
    {
        $query = $this->find($id);
        if ($query === null) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 404,
                    'message'   => 'User not found',
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        $query->password    = $data['password'];
        $query->save();

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Password updated successfully',
                'errors'    => []
            ],
            'data' => null,
        ];
    }

    public function updateRole(string $id, array $data): array
    {
        $query = $this->find($id);
        $query->syncRoles($data['roles']);

        $query->save();

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Role updated successfully',
                'errors'    => []
            ],
            'data' => null,
        ];
    }

    public function updateSetting(string $id, array $data): array
    {
        $user = $this->find($id);
        $query = $user->userSetting()->updateOrCreate([
            'user_id' => $user->id,
        ], [
            'entity_id' => $data['entity_id'],
        ]);

        if ($user->userSetting) {
            $entity = $user->userSetting->entity;
            if ($entity) {
                $user->full_name = $entity->full_name;
                $user->save();
            }
        }

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'User setting updated successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }

    public function destroy(string $id, array $data): array
    {
        $query = $this->find($id);
        if ($query === null) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 404,
                    'message'   => 'User not found',
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
                'message'   => 'User deleted successfully',
                'errors'    => []
            ],
            'data' => null,
        ];
    }
}
