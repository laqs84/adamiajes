<?php

namespace App\Admin\Controllers;

Use App\Models\Empresas;
Use App\Models\EmpresaPruebas;
Use App\Models\Puestos;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Redirect;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Arr;

class EmpresaPruebasController extends Controller
{
    public function index(){
        
        $empresas = Empresas::all();
        $EmpresaPruebas = EmpresaPruebas::all();
        $puestosAll = Puestos::all();
        $empresasp_arr = array();
        foreach ($EmpresaPruebas as $key => $value) {

           $puestos = Puestos::where('con_pue', $value['con_pue'])->get();
           $empresasp_item = array(
            "descripcion" => $value['descripcion'] ? $value['descripcion'] : "No hay dato",
            "con_pue" => $puestos[0]['descripcion'] ? $puestos[0]['descripcion']  : "No hay dato",            
            "fecha_inicio" => $value['fecha_inicio'] ? $value['fecha_inicio'] : "No hay dato",                       
            "fecha_limite" => $value['fecha_limite'] ? $value['fecha_limite'] : "No hay dato",            
            "tiempo_limite" => $value['tiempo_limite'] ? $value['tiempo_limite'] : "No hay dato",                                    
            "acciones" => '<a style="font-size: 16px;color:green;" href="#" onclick="detalle(this)" class="detalle-' . $value['numsec_prueba'] . '"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" href="#" onclick="eliminar(this)" class="eliminar-' . $value['numsec_prueba'] . '"><i class="fa fa-trash"></i></a> | <a href="#" onclick="agrega_test(this)" class="comp-' . $value['numsec_prueba'] . '">Agregar Test</a> <a href="#" onclick="agrega_candidato(this)" class="comp-' . $value['numsec_prueba'] . '">Agregar candidato</a>'
        );
        array_push($empresasp_arr, $empresasp_item);
        }
        
        return view('admin.empresa_pruebas' , ['empresa_pruebas' => $empresasp_arr, 'puestos' => $puestosAll, 'empresas' => $empresas, '_user_'      => $this->getUserData()]);
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
      $request->input('p_mdesc');
       if($request['numsec_prueba'] !== NULL){
         $update = \DB::table('empresa_pruebas') ->where('numsec_prueba', $request['numsec_prueba']) ->limit(1) ->update( [ 'descripcion' => $request['descripcion'], 'con_pue' => $request['con_pue'], 'fecha_inicio' => $request['fecha_inicio'], 'fecha_limite' => $request['fecha_limite'], 'tiempo_limite' => $request['tiempo_limite']]);  
       }
       else{
         $EmpresaPruebas= EmpresaPruebas::create($request->all());  
         
       }

        return Redirect::to('admin/empresa_pruebas');
    }
    
    public function delete($id)
    {
        DB::table('empresa_pruebas')->where('numsec_prueba', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
    
    
    
    
}
