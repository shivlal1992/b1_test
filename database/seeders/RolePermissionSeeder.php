<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          // Create roles
          $superAdmin = Role::create(['name' => 'Super Admin']);
          $districtAdmin = Role::create(['name' => 'District Admin']);
  
          // Create permissions
          $permissions = [
              'manage users',
              'manage roles',
              'manage districts',
          ];
  
          foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
          }
  
          // Assign permissions
          $superAdmin->givePermissionTo(Permission::all()); // Full access
          $districtAdmin->givePermissionTo(['manage districts']); // Limited access
    }
}
