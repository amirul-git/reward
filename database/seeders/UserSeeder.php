<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = collect(
            [
                'view rewards',
                'show rewards',
                'create rewards',
                'store rewards',
                'edit rewards',
                'update rewards',
                'delete rewards',
                'view products',
                'show products',
                'create products',
                'store products',
                'edit products',
                'update products',
                'delete products',
                'view structs',
                'show structs',
                'create structs',
                'store structs',
                'edit structs',
                'update structs',
                'delete structs',
                'view points',
                'show points',
                'create points',
                'store points',
                'edit points',
                'update points',
                'delete points',
            ]
        );

        $permissions->each(function ($permission) {
            Permission::create(['name' => $permission]);
        });

        $adminRole = Role::create(['name' => 'admin']);
        $permissions->each(function ($permission) use ($adminRole) {
            $adminRole->givePermissionTo($permission);
        });

        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'andik@mail.com',
        ]);
        $user->assignRole('admin');

        $permissions = collect(
            [
                'view structs',
                'show structs',
                'create structs',
                'store structs',
                'edit structs',
                'update structs',
                'delete structs',
                'view points',
                'show points',
                'create points',
                'store points',
                'edit points',
                'update points',
                'delete points',
            ]
        );
        $workerRole = Role::create(['name' => 'worker']);
        $permissions->each(function ($permission) use ($workerRole) {
            $workerRole->givePermissionTo($permission);
        });
        $user = \App\Models\User::factory()->create([
            'name' => 'Amir',
            'email' => 'amir@mail.com',
        ]);
        $user->assignRole('worker');

        $user = \App\Models\User::factory()->create([
            'name' => 'Adip',
            'email' => 'adip@mail.com',
        ]);
        $user->assignRole('worker');

        $permissions = collect(
            [
                'view rewards',
                'show rewards',
                'create rewards',
                'store rewards',
                'edit rewards',
                'update rewards',
                'delete rewards',
                'view points',
                'show points',
                'create points',
                'store points',
                'edit points',
                'update points',
                'delete points',
            ]
        );

        $buyerRole = Role::create(['name' => 'buyer']);

        $permissions->each(function ($permission) use ($buyerRole) {
            $buyerRole->givePermissionTo($permission);
        });

        $user = \App\Models\User::factory()->create([
            'name' => 'fia',
            'email' => 'fia@mail.com',
        ]);
        $user->assignRole('buyer');

        $user = \App\Models\User::factory()->create([
            'name' => 'krisma',
            'email' => 'krisma@mail.com',
        ]);
        $user->assignRole('buyer');
    }
}
