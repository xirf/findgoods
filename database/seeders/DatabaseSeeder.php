<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder {
    private $permissions  = [
        'role-list',
        'role-create',
        'role-edit',
        'role-delete',
        'menu-list',
        'menu-create',
        'menu-edit',
        'menu-delete'
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void {
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@main.test',
            'password' => Hash::make('admin')
        ]);

        $role = Role::create(['name' => 'Admin']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $admin->assignRole([$role->id]);

        $staff = User::create([
            'name' => 'Staff',
            'email' => 'staff@main.test',
            'password' => Hash::make('staff')
        ]);

        $role = Role::create(['name' => 'Staff']);

        $permission = Permission::where('name', 'menu-list')->first();
        $role->syncPermissions([$permission->id]);
        $staff->assignRole([$role->id]);
    }
}
