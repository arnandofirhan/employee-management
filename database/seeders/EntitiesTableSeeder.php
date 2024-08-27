<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Entity;
use App\Models\EntityCategory;
use Illuminate\Database\Seeder;

use DB;

class EntitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            $data = [
                // [
                //     'full_name' => 'Arnando Firhan Prayudha',
                //     'is_active' => true,
                //     'entity_categories' => [
                //         'EMPLOYEE',
                //     ],
                // ],
            ];

            foreach ($data as $item) {
                $query = Entity::query()
                    ->updateOrCreate([
                        'full_name' => $item['full_name'],
                    ], [
                        'is_active' => $item['is_active'],
                        'created_by' => null,
                        'updated_by' => null,
                    ]);

                $user = User::query()->where('full_name', $item['full_name'])->first();
                if ($user) {
                    if ($user->userSetting) {
                        $userSetting = $user->userSetting;
                        $userSetting->entity_id = $query->id;
                        $userSetting->save();
                    } else {
                        dd("user->userSetting ~> User does'nt have setting not found: " . $user->full_name);
                    }
                } else {
                    $query->is_active = false;
                    $query->save();
                }

                $entityCategories = EntityCategory::query()->whereIn('value', $item['entity_categories'])->get();
                $query->entityCategories()->sync($entityCategories);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            dd($e);
        }
    }
}
