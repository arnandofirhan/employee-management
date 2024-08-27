<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

use DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            $data = [
                'auth.edit',
                'auth.edit-email',
                'auth.edit-password',

                'role.list',
                'role.create',
                'role.edit',
                'role.destroy',

                'user.list',
                'user.create',
                'user.edit',
                'user.edit-security',
                'user.edit-role',
                'user.edit-setting',
                'user.destroy',

                'dashboard.main',

                'entity-category.list',
                'entity-category.edit',

                'entity.list',
                'entity.create',
                'entity.edit',
                'entity.destroy',
                'entity.import',
                'entity.export',

                'department.list',
                'department.create',
                'department.edit',
                'department.destroy',

                'employee-status.list',
                'employee-status.create',
                'employee-status.edit',
                'employee-status.destroy',
            ];

            $itemIds = Permission::query()->pluck('id', 'id');
            foreach ($data as $itemName) {
                $query = Permission::query()->updateOrCreate([
                    'name' => $itemName
                ]);

                if ($itemIds->contains($query->id)) {
                    $itemIds->forget($query->id);
                }
            }

            if ($itemIds->count()) {
                Permission::query()->whereIn('id', $itemIds->toArray())->delete();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            dd($e);
        }
    }
}
