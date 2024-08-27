<?php

namespace Database\Seeders;

use App\Models\EmployeeStatus;
use Illuminate\Database\Seeder;

use DB;

class EmployeeStatusesTableSeeder extends Seeder
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
                    'name' => 'Tetap',
                    'is_active' => true,
                ],
                [
                    'name' => 'Kontrak',
                    'is_active' => true,
                ],
                [
                    'name' => 'Training',
                    'is_active' => true,
                ],
            ];

            foreach ($data as $item) {
                $query = EmployeeStatus::query()
                    ->updateOrCreate([
                        'name' => $item['name'],
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
