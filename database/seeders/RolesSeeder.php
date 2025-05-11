<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Administrador
        $roleAdmin = Role::create(['name' => 'admin']);

        // Usuario
        $roleUsuario = Role::create(['name' => 'usuario']);

        // ROLES Y PERMISOS
        Permission::create(['name' => 'sidebar.roles.y.permisos', 'description' => 'sidebar seccion roles y permisos'])->syncRoles($roleAdmin);

        // PERMISO PARA VISTA DASHBOARD
        Permission::create(['name' => 'sidebar.dashboard', 'description' => 'sidebar dashboard'])->syncRoles($roleUsuario);

    }
}
