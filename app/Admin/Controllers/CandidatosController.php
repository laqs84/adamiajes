<?php

namespace App\Admin\Controllers;

Use App\Models\Personas;
Use App\Models\Empresas;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Redirect;

class CandidatosController extends Controller
{
    public function index(){
        
        
        $candidatos = Personas::all();
        
        $empresas = Empresas::all();
        
        
        $acciones = '';
        $candidatos_arr = array();
        foreach ($candidatos as $key => $value) {
            $empresas = Empresas::where('con_emp', $value['con_emp'])->get();
            $candidatos_item = array(
            "con_emp" => $empresas->pluck("descripcion")->first() ? $empresas->pluck("descripcion")->first() : "No hay dato",
            "tipo_identificacion" => $value['tipo_identificacion'] ? $value['tipo_identificacion'] : "No hay dato",
            "num_identificacion" => $value['num_identificacion'] ? $value['num_identificacion'] : "No hay dato",
            "nombres" => $value['nombres'] ? $value['nombres'] : "No hay dato",
            "apellido1" => $value['apellido1'] ? $value['apellido1'] : "No hay dato",
            "apellido2" => $value['apellido2'] ? $value['apellido2'] : "No hay dato",
            "email" => $value['email'] ? $value['email'] : "No hay dato",
            "acciones" => '<a style="font-size: 16px;color:green;" title="Editar" href="#" onclick="detalle(this)" class="detalle-' . $value['con_persona'] . '"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" title="Eliminar" href="#" onclick="eliminar(this)" class="eliminar-' . $value['con_persona'] . '"><i class="fa fa-trash"></i></a>');
        array_push($candidatos_arr, $candidatos_item);
        }
        
        return view('admin.candidatos' , ['empresas' => $empresas, 'candidatos' => $candidatos_arr, '_user_'      => $this->getUserData()]);
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
       if($request['con_persona'] !== null){
         $update = \DB::table('personas') ->where('con_persona', $request['con_persona']) ->limit(1) ->update( [ 'con_emp' => $request['con_emp'], 'tipo_identificacion' => $request['tipo_identificacion'], 'num_identificacion' => $request['num_identificacion'], 'nombres' => $request['nombres'], 'apellido1' => $request['apellido1'], 'apellido2' => $request['apellido2'], 'email' => $request['email']]);  
       }
       else{
         $competencias = Personas::create($request->all());  
       }

        return Redirect::to('admin/candidatos');
    }
    
    public function delete($id)
    {
        DB::table('personas')->where('con_persona', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
    
    
    
    
}
