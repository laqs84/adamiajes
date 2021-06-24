<?php

namespace App\Admin\Controllers;

Use App\Models\Empresas;
Use App\Models\CompetenciasTipos;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Redirect;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Arr;

class EmpresasController extends Controller
{
    public function index(){
        
        $empresas = Empresas::all();
        $competenciasTipos = CompetenciasTipos::all();
        $empresas_arr = array();
        foreach ($empresas as $key => $value) {
           $competenciasTipo = CompetenciasTipos::where('con_tipo', $value['puntaje_base'])->get();
           $empresas_item = array(
            "descripcion" => $value['descripcion'] ? $value['descripcion'] : "No hay dato",
            "email" => $value['email'] ? $value['email'] : "No hay dato",
            "contacto" => $value['contacto'] ? $value['contacto'] : "No hay dato",
            "telefono" => $value['telefono'] ? $value['telefono'] : "No hay dato",
            "puntaje_base" => $value['puntaje_base'] ? $value['puntaje_base'] : "No hay dato",
            "acciones" => '<a style="font-size: 16px;color:green;" href="#" onclick="detalle(this)" class="detalle-' . $value['con_emp'] . '"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" href="#" onclick="eliminar(this)" class="eliminar-' . $value['con_emp'] . '"><i class="fa fa-trash"></i></a> | <a href="#" onclick="puestocomp(this)" class="puestocomp-' . $value['con_emp'] . '">Crear un puesto y competencia</a>'
        );
        array_push($empresas_arr, $empresas_item);
        }
        
        return view('admin.empresas' , ['empresas' => $empresas_arr, 'competenciasTipos' => $competenciasTipos, '_user_'      => $this->getUserData()]);
   }
   
   protected function getUserData()
    {
        if (!$user = Admin::user()) {
            return [];
        }

        return Arr::only($user->toArray(), ['id', 'username', 'email', 'name', 'avatar']);
    }
   
   public function store(Request $request)
    {
       if($request['con_emp'] !== NULL){
         $update = \DB::table('empresas') ->where('con_emp', $request['con_emp']) ->limit(1) ->update( [ 'descripcion' => $request['descripcion'], 'email' => $request['email'], 'contacto' => $request['contacto'], 'telefono' => $request['telefono'], 'puntaje_base' => $request['puntaje_base']]);  
       }
       else{
         $empresas = Empresas::create($request->all());  
         
       }

        return Redirect::to('admin/empresas');
    }
    
    public function delete($id)
    {
        DB::table('empresas')->where('con_emp', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
    
    
    
    
}
