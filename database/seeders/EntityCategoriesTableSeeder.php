<?php

namespace Database\Seeders;

use App\Models\EntityCategory;
use Illuminate\Database\Seeder;

use DB;

class EntityCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            $data = [
                [
                    'name' => 'Employee',
                    'value' => 'EMPLOYEE',
                    'sequence' => 1,
                    'background_color_code' => '#1B84FF',
                    'font_color_code' => '#FFFFFF',
                    'is_active' => true,
                ],
                // [
                //     'name' => 'Supplier',
                //     'value' => 'SUPPLIER',
                //     'sequence' => 1,
                //     'background_color_code' => '#7239EA',
                //     'font_color_code' => '#FFFFFF',
                //     'is_active' => true,
                // ],
                // [
                //     'name' => 'Customer',
                //     'value' => 'CUSTOMER',
                //     'sequence' => 1,
                //     'background_color_code' => '#F6C000',
                //     'font_color_code' => '#FFFFFF',
                //     'is_active' => true,
                // ],
            ];

            foreach ($data as $item) {
                $query = EntityCategory::query()
                    ->updateOrCreate([
                        'value' => $item['value'],
                    ], [
                        'name' => $item['name'],
                        'sequence' => $item['sequence'],
                        'background_color_code' => $item['background_color_code'],
                        'font_color_code' => $item['font_color_code'],

                        'is_active' => $item['is_active'],
                        'created_by' => null,
                        'updated_by' => null,
                    ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            dd($e);
        }
    }
}
