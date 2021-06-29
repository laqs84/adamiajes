<?php

namespace App\Admin\Controllers;

Use App\Models\Permisos;
Use App\Models\Roles;
Use App\Models\RolesAdmin;
Use App\Models\RolesAdminPermisos;
Use App\Models\Empresas;
Use App\Models\Administradores;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Arr;
Use App\Models\CompetenciasTipos;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Str;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;
use Illuminate\Support\Facades\Hash;

class AdministradoresControllers extends Controller
{
    
     public function index(Request $request){
        
       if($request["id"]){
            $empresasAll = Empresas::where('con_emp', $request["id"])->get();
            
         
        }
        else{
        
            $empresasAll = Empresas::all();
            
        }
        
        $rolesAll = Roles::all();
        $permisosAll = Permisos::all();
        
        $administradoresAll = Administradores::all();
        
        $administradores_arr = array();
        foreach ($administradoresAll as $key => $value) {
           $empresas = Empresas::where('con_emp', $value['con_emp'])->get();
           $rolUser = RolesAdmin::where('user_id', $value['id'])->get();
           $rol= Roles::where('id', $rolUser->pluck("role_id")->first())->get();
           $rolPermisos= RolesAdminPermisos::where('role_id', $rolUser->pluck("role_id")->first())->get();
           $permisosuser = "";
           foreach ($rolPermisos as $key2 => $value2) {
             $permisos= Permisos::where('id', $value2["permission_id"])->get();
             $nombrePermisos = $permisos->pluck("name")->first();
             $permisosuser .= "<span class='label label-success'>".$nombrePermisos. "</span> ";
             
           }
           
           
           $administradores_item = array(
            "con_emp" => $empresas->pluck("descripcion")->first() ? $empresas->pluck("descripcion")->first() : "No hay dato",
            "username" => $value['username'] ? $value['username'] : "No hay dato",
            "name" => $value['name'] ? $value['name'] : "No hay dato",
            "rol" => "<span class='label label-success'>".$rol->pluck("name")->first(). "</span> " ? "<span class='label label-success'>".$rol->pluck("name")->first(). "</span> " : "No hay dato",
            "persmisos" => $permisosuser ? $permisosuser : "No hay dato",
            "acciones" => '<a style="font-size: 16px;color:green;" href="#" onclick="detalle(this)" class="detalle-' . $value['id'] . '"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" href="#" onclick="eliminar(this)" class="eliminar-' . $value['id'] . '"><i class="fa fa-trash"></i></a>'
        );
          // var_dump($value['con_pue']);
        array_push($administradores_arr, $administradores_item);
        }
       
        
        
        return view('admin.administradores' , ['admin' => $administradores_arr, 'empresas' => $empresasAll, 'roles' => $rolesAll, 'permisos' => $permisosAll, '_user_'      => $this->getUserData()]);
   }
    protected function getUserData()
    {
        if (!$user = Admin::user()) {
            return [];
        }

        return Arr::only($user->toArray(), ['id', 'username', 'email', 'name', 'avatar']);
    }
    
    
    public function store(Request $request, Content $content)
    {
        
        if($request['id'] !== null){
         $update = \DB::table('admin_users') ->where('id', $request['id']) ->limit(1) ->update( [ 'con_emp' => $request['con_emp'], 'username' => $request['username'],'name' => $request['name'], 'avatar' => $request['avatar']]);  
         return $content
            ->description($this->description['create'] ?? trans('admin.create'));
       }
       else{
        if($request["password_confirmation"] == $request["password"]){
            $request["password"] = Hash::make($request["password"]);
        }
        else{
            return false;
        }
        $request["remember_token"] = Str::random(60);
        $administradores = Administradores::create($request->all());  
        
        //var_dump();
        $rolUser =  new RolesAdmin;
        $rolUser->role_id = $request["rol"];
        $rolUser->user_id = $administradores->pluck("id")->last();
        $rolUser->save();
        return $content
            ->description($this->description['create'] ?? trans('admin.create'));
        
          /* foreach ($request["permissions"] as $key2 => $value2) {
             $permisos= RolesAdminPermisos::create('role_id',$request["rol"], 'permission_id', $value2["permissions"]);
             
           }*/
        
        }
    }
    
    
    public function delete($id)
    {
        DB::table('admin_users')->where('id', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
}