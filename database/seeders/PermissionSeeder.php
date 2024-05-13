<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminManger = [
            'create user',
            'delete user',
            'edit user',
            'list user',
            'create school',
            'delete school',
            'edit school',
            'create course',
            'delete course',
            'edit course',
            'setting',
            'delete evaluation',

        ];
        $manager = [
            'export report',
            'create teacher',
            'list user',
            'list course',
            'list school',
            'create block',
            'delete block',
            'edit block',
            'list block'
        ];
        $teacher = [
            'view report',
            'create question',
            'delete question',
            'edit question',
            'list question',
            'create answer',
            'delete answer',
            'edit answer',
            'list answer',
            'create category',
            'delete category',
            'edit category',
            'list category',
        ];
        $student = [
            'register evaluation',
            'personal report'
        ];

        $roles = [
            'admin' => [
                ...$adminManger,
                ...$manager,
                ...$teacher,
                ...$student
            ],
            'manager' => [
                ...$manager,
                ...$teacher,
            ],
            'teacher' => [
                ...$teacher,
            ],
            'student' => [
                $student
            ]
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName], ['name' => $roleName]);

            foreach ($permissions as $permissionName) {
                $permission = Permission::firstOrCreate(['name' => $permissionName], ['name' => $permissionName]);

                $permission->assignRole($role);
            }
        }
    }

}
