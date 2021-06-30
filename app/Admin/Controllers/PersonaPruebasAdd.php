<?php

namespace App\Admin\Controllers;

Use App\Models\Empresas;
Use App\Models\EmpresaPruebas;
Use App\Models\EmpresasPruebasBase;
Use App\Models\EmpresaPruebasDetalle;
Use App\Models\Competencias;
Use App\Models\CompetenciasNiveles;
Use App\Models\EmpresasCompetenciasNiveldominio;
Use App\Models\Puestos;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Redirect;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Arr;

class PersonaPruebasAdd extends Controller
{
    public function index(Request $request){
        
        if($request["id"]){
      
            $empresaPruebas = EmpresaPruebas::where('numsec_prueba', $request["id"])->get();
            $con_emp = $empresaPruebas[0]->con_emp;
            $titulo = "Test a incluir en esta prueba";
            $empresaTestAll = EmpresasPruebasBase::where('con_emp', $con_emp)->get();
            $empresaPruebasDetalle = EmpresaPruebasDetalle::where('numsec_prueba', $request["id"])->get();
            $empresasAll = Empresas::where('con_emp', $con_emp)->get();
            $competenciasAll = Competencias::all();
            // $competenciasNivelesAll = CompetenciasNiveles::all();
            // $puestosAll = Puestos::all();
         
        }
        else{
        
 
            $empresasAll = Empresas::all();
            $competenciasAll = Competencias::all();
            $empresaPruebasDetalle = EmpresaPruebasDetalle::all();            
            // $competenciasNivelesAll = CompetenciasNiveles::all();
            // $puestosAll = Puestos::all();
        }
        $empresas_arr = array();
        foreach ($empresaPruebasDetalle as $key => $value) {
           $empresaTest = EmpresasPruebasBase::where('con_test', $value['con_test'])->get();
           $empresas = Empresas::where('con_emp', $value['con_emp'])->get();
           $empresas_item = array(
            "con_emp" => $empresas[0]['descripcion'] ? $empresas[0]['descripcion'] : "No hay dato",
            "numsec_prueba" => $value['numsec_prueba'] ? $value['numsec_prueba'] : "No hay dato",
            "con_test" => $empresaTest[0]['descripcion'] ? $empresaTest[0]['descripcion'] : "No hay dato",            
            "acciones" => '<a style="font-size: 16px;color:green;" href="#" onclick="detalle(this)" class="detalle-' . $value['con_detpru'] . '"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" href="#" onclick="eliminar(this)" class="eliminar-' . $value['con_detpru'] . '"><i class="fa fa-trash"></i></a>'
        );
          // var_dump($value['con_pue']);
       array_push($empresas_arr, $empresas_item);
        }
        
        //var_dump($competenciasNivelesAll);
        
       return view('admin.persona_pruebas_add' , ['persona_pruebas' => $empresas_arr, 'test' => $empresaTestAll, 'empresas' => $empresasAll, 'numsec_prueba' => $request["id"],  'titulo' => $titulo, '_user_'  => $this->getUserData()]);
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
       if($request['con_detpru'] !== null){
         $update = \DB::table('persona_pruebas') ->where('con_persona', $request['con_persona']) ->limit(1) ->update( [ 'con_test' => $request['con_test']]);  
       }
       else{
         $empresas = PersonaPruebas::create($request->all());  
       }

 
        return Redirect::to('admin/persona_pruebas_add/'.$request['numsec_prueba']);

        
    }
    
    public function delete($id)
    {
        DB::table('personas_pruebas')->where('num_pruper', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
    
    
    
    
}
