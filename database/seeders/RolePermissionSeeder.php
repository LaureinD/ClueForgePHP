<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'User management' => ['view.user', 'create.user', 'update.user', 'delete.user', 'restore.user', 'forceDelete.user']
        ];

        foreach ($categories as $categoryName => $permissions) {
            $category = Category::where('name', $categoryName)->first();

            foreach($permissions as $permissionName) {
                $permission = Permission::firstOrCreate(['name' => $permissionName]);
                $permission->categories()->syncWithoutDetaching([$category->id]);
            }
        }

        Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());
        Role::create(['name' => 'moderator']);
        Role::create(['name' => 'user']);
    }
}
