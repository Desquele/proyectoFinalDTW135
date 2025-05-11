<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Usuario::create([
            'nombre' => 'Administrador',
            'usuario' => 'admin',
            'password' => bcrypt('1234'),
            'activo' => 1,
        ])->assignRole('admin');
        
        Usuario::create([
            'nombre' => 'Usuario',
            'usuario' => 'usuario',
            'password' => bcrypt('1234'),
            'activo' => 1,
        ])->assignRole('usuario');
    }
}
