<?php

namespace App\Admin\Controllers;

Use App\Models\Empresas;
Use App\Models\EmpresaPruebas;
Use App\Models\Puestos;
Use App\Models\Competencias;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Redirect;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Arr;

class EmpresaPruebasController extends Controller
{
    public function index(Request $request){
        
        if($request["id"]){
            $empresasAll = Empresas::where('con_emp', $request["id"])->get();
            
         
        }
        else{
        
            $empresasAll = Empresas::all();
            
        }
        $Competencias = Competencias::all();
        $puestosAll = Puestos::all();
        $empresaspruebas = EmpresaPruebas::all();
        $empresas_arr = array();
        foreach ($empresaspruebas as $key => $value) {
           $puestos = Puestos::where('con_pue', $value['con_pue'])->get();
           $empresas = Empresas::where('con_emp', $value['con_emp'])->get();
           $empresas_item = array(
            "con_emp" => $empresas[0]['descripcion'] ? $empresas[0]['descripcion'] : "No hay dato",
            "con_pue" => $puestos[0]['descripcion'] ? $puestos[0]['descripcion'] : "No hay dato",
            "descripcion" => $value['descripcion'] ? $value['descripcion'] : "No hay dato",
            "fecha_creacion" => $value['fecha_creacion'] ? $value['fecha_creacion'] : "No hay dato",
            "fecha_limite" => $value['fecha_limite'] ? $value['fecha_limite'] : "No hay dato",
            "tiempo_limite" => $value['tiempo_limite'] ? $value['tiempo_limite'] : "No hay dato",
            "link_prueba" => $value['link_prueba'] ? $value['link_prueba'] : "No hay dato",
            "acciones" => '<a style="font-size: 16px;color:green;" href="#" onclick="detalle(this)" class="detalle-' . $value['numsec_prueba'] . '"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" href="#" onclick="eliminar(this)" class="eliminar-' . $value['numsec_prueba'] . '"><i class="fa fa-trash"></i></a>'
        );
          // var_dump($value['con_pue']);
        array_push($empresas_arr, $empresas_item);
        }
        
        
        
        return view('admin.empresapruebas' , ['empresaspruebas' => $empresas_arr, 'empresas' => $empresasAll, 'competencias' => $Competencias, 'puestos' => $puestosAll, '_user_'      => $this->getUserData()]);
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
       if($request['numsec_prueba'] !== null){
         $update = \DB::table('empresa_pruebas') ->where('numsec_prueba', $request['numsec_prueba']) ->limit(1) ->update( [ 'con_emp' => $request['con_emp'], 'con_pue' => $request['con_pue'], 'descripcion' => $request['descripcion'], 'fecha_creacion' => $request['fecha_creacion'], 'fecha_limite' => $request['fecha_limite'], '	tiempo_limite' => $request['tiempo_limite'], 'link_prueba' => $request['link_prueba']]);  
       }
       else{
         $empresas = EmpresasPruebas::create($request->all());  
       }

        return Redirect::to('admin/empresaspruebas');
    }
    
    public function delete($id)
    {
        DB::table('empresa_pruebas')->where('numsec_prueba', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
    
    
    
    
}
