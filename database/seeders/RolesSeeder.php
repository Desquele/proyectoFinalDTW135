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
        // Permisos para el admin
        $adminPermissions = [
            'sidebar.roles.y.permisos',
            'sidebar.dashboard',
            'crear.tickets',
            'editar.tickets',
            'ver.tickets',
            'eliminar.tickets',
        ];

        foreach ($adminPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission])
                      ->syncRoles($roleAdmin);
        }
       
        // PERMISO PARA VISTA DASHBOARD
        Permission::firstOrCreate(
    ['name' => 'sidebar.dashboard', 'guard_name' => 'web'],
    ['description' => 'sidebar dashboard'])->syncRoles($roleUsuario);


    }
}
