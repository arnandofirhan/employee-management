<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

use DB;

class DepartmentsTableSeeder extends Seeder
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
                    'full_name' => 'Assembling',
                    'is_active' => true,
                ],
                [
                    'full_name' => 'Injection',
                    'is_active' => true,
                ],
                [
                    'full_name' => 'Quality Control',
                    'is_active' => true,
                ],
            ];

            foreach ($data as $item) {
                $query = Department::query()
                    ->updateOrCreate([
                        'full_name' => $item['full_name'],
                    ], [
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
