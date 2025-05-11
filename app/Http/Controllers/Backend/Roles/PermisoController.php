<?php

namespace App\Http\Controllers\Backend\Roles;

use App\Http\Controllers\Controller;
use App\Models\BodegaUsuarioObjEspecifico;
use App\Models\ConsolidadoresUnidades;
use App\Models\ObjEspecifico;
use App\Models\P_Departamento;
use App\Models\P_PresupUnidad;
use App\Models\P_UsuarioDepartamento;
use App\Models\Usuario;
use App\Models\UsuarioFormulador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //retorna vista de "Permisos" en sisdebar
    public function index(){
        $roles = Role::all()->pluck('name', 'id');

        return view('backend.admin.rolesypermisos.permisos', compact('roles'));
    }

    // muestra tabla de usuarios del sistema
    public function tablaUsuarios(){
        $usuarios = Usuario::orderBy('id', 'ASC')->get();
        return view('backend.admin.rolesypermisos.tabla.tablapermisos', compact('usuarios'));
    }

    // crear nuevo usuario
    public function nuevoUsuario(Request $request){

        // verificar que usuario no este registrado
        if(Usuario::where('usuario', $request->usuario)->first()){
            return ['success' => 1];
        }
        DB::beginTransaction();

        try {

            $reg = new Usuario();
            $reg->nombre = $request->nombre;
            $reg->usuario = $request->usuario;
            $reg->password = bcrypt($request->password);
            $reg->activo = 1;
            $reg->save();

            $roleName = Role::find($request->rol)->name; // Busca el nombre del rol usando el ID
            $reg->assignRole($roleName);

            DB::commit();
            return ['success' => 2];
        } catch (\Throwable $e) {
            Log::info('error ' . $e);
            DB::rollback();
            return ['success' => 99];
        }
    }

    // obtener información de un usuario
    public function infoUsuario(Request $request){
        if($info = Usuario::where('id', $request->id)->first()){

            $roles = Role::all()->pluck('name', 'id');

            $idrol = $info->roles->pluck('id');

            return ['success' => 1,
                'info' => $info,
                'roles' => $roles,
                'idrol' => $idrol];

        }else{
            return ['success' => 2];
        }
    }

    // editar un usuario
    public function editarUsuario(Request $request){

        if(Usuario::where('id', $request->id)->first()){

            // verificar que usuario no este repetido
            if(Usuario::where('usuario', $request->usuario)
                ->where('id', '!=', $request->id)->first()){
                return ['success' => 1];
            }


            DB::beginTransaction();

            try {

                $usuario = Usuario::find($request->id);
                $usuario->nombre = $request->nombre;
                $usuario->usuario = $request->usuario;
                $usuario->activo = $request->toggle;

                if($request->password != null){
                    $usuario->password = bcrypt($request->password);
                }

                //elimina el rol existente y agrega el nuevo.
                $roleName = Role::find($request->rol)->name;
                $usuario->syncRoles($roleName);
                $usuario->save();

                DB::commit();
                return ['success' => 2];
            }catch(\Throwable $e){
                DB::rollback();
                return ['success' => 99];
            }

        }else{
            return ['success' => 3];
        }
    }

    // crear un nuevo Rol
    public function nuevoRol(Request $request){

        $regla = array(
            'nombre' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        // verificar si existe el rol
        if(Role::where('name', $request->nombre)->first()){
            return ['success' => 1];
        }

        Role::create(['name' => $request->nombre]);

        return ['success' => 2];
    }

    // crear nuevos permisos
    public function nuevoPermisoExtra(Request $request){

        // verificar si existe el permiso
        if(Permission::where('name', $request->nombre)->first()){
            return ['success' => 1];
        }

        Permission::create(['name' => $request->nombre, 'description' => $request->descripcion]);

        return ['success' => 2];
    }

    // borrar permiso global, a todos los roles que lo contenga
    public function borrarPermisoGlobal(Request $request){

        // buscamos el permiso el cual queremos eliminar
        Permission::findById($request->idpermiso)->delete();

        return ['success' => 1];
    }
}
