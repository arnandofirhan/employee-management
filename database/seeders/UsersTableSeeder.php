<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use DB;

class UsersTableSeeder extends Seeder
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
                    'full_name' => 'Sintas Support',
                    'username' => 'support@membasuh.com',
                    'email' => 'support@membasuh.com',
                    'email_verified_at' => now(),
                    'password' => '$2y$12$vgPzaiZB3IQMwU/Y90hUH.GeW/W.6TcJaYcxc5CPVgfSRYXaf/Hye',
                    'image_url' => null,
                    'remember_token' => Str::random(10),
                    'is_active' => true,
                    'roles' => Role::query()->whereIn('name', ['Main', 'Superadmin'])->get()
                ],
                [
                    'full_name' => 'Arnando Firhan Prayudha',
                    'username' => 'arnandofp@gmail.com',
                    'email' => 'arnandofp@gmail.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'image_url' => null,
                    'remember_token' => Str::random(10),
                    'is_active' => true,
                    'roles' => Role::query()->whereIn('name', ['Superadmin'])->get()
                ],
            ];

            foreach ($data as $item) {
                $query = User::query()
                    ->updateOrCreate([
                        'full_name' => $item['full_name'],
                        'username' => $item['username'],
                    ], [
                        'email' => $item['email'],
                        'email_verified_at' => $item['email_verified_at'],
                        'password' => $item['password'],
                        'image_url' => $item['image_url'],
                        'remember_token' => $item['remember_token'],
                        'is_active' => $item['is_active'],
                        'created_by' => null,
                        'updated_by' => null,
                    ]);

                if (count($item['roles'])) {
                    $query->syncRoles($item['roles']);
                }

                $query->userSetting()->updateOrCreate([
                    'user_id' => $query->id,
                ], [
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
