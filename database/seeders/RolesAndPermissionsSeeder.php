<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Membuat izin
        Permission::create(['name' => 'entity.export']);

        // Membuat peran dan menetapkan izin
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo('entity.export');

        // Menetapkan peran kepada pengguna tertentu
        $user = \App\Models\User::find(1);
        $user->assignRole('admin');
    }
}
