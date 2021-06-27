<?php

namespace App\Admin\Controllers;

Use App\Models\Empresas;
Use App\Models\EmpresasPruebasBase;
Use App\Models\EmpresasPruebasBaseDetalle;
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

class EmpresasPruebasBaseDetalleController extends Controller
{
    public function index(Request $request){
        
        if($request["id"]){
            $empresasPruebasBase = EmpresasPruebasBase::where('con_test', $request["id"])->get();
            $con_emp = $empresasPruebasBase[0]->con_emp;
            $titulo = "Competencias a excluir de la prueba";
            if($empresasPruebasBase[0]->usa_allcompdis !="on"){
              $titulo = "Competencias a incluir en la prueba";
            };
            $empresasPruebasBaseDetalle = EmpresasPruebasBaseDetalle::where('con_test', $request["id"])->get();
            $empresasAll = Empresas::where('con_emp', $con_emp)->get();
            $competenciasAll = Competencias::all();
            // $competenciasNivelesAll = CompetenciasNiveles::all();
            // $puestosAll = Puestos::all();
         
        }
        else{
        
 
            $empresasAll = Empresas::all();
            $competenciasAll = Competencias::all();
            $empresasPruebasBaseDetalle = EmpresasPruebasBaseDetalle::all();            
            // $competenciasNivelesAll = CompetenciasNiveles::all();
            // $puestosAll = Puestos::all();
        }
        $empresas_arr = array();
        foreach ($empresasPruebasBaseDetalle as $key => $value) {
           $competencias = Competencias::where('con_comp', $value['con_comp'])->get();
           $empresas = Empresas::where('con_emp', $value['con_emp'])->get();
           $empresas_item = array(
            "con_emp" => $empresas[0]['descripcion'] ? $empresas[0]['descripcion'] : "No hay dato",
            "con_comp" => $competencias[0]['descripcion'] ? $competencias[0]['descripcion'] : "No hay dato",
            "acciones" => '<a style="font-size: 16px;color:green;" href="#" onclick="detalle(this)" class="detalle-' . $value['con_detprubas'] . '"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" href="#" onclick="eliminar(this)" class="eliminar-' . $value['con_detprubas'] . '"><i class="fa fa-trash"></i></a>'
        );
          // var_dump($value['con_pue']);
       array_push($empresas_arr, $empresas_item);
        }
        
        //var_dump($competenciasNivelesAll);
        
       return view('admin.emp_pru_base_detalle' , ['empresas_pruebas_base_detalle' => $empresas_arr, 'competencias' => $competenciasAll, 'empresas' => $empresasAll, 'con_test' => $request["id"],  'titulo' => $titulo, '_user_'      => $this->getUserData()]);
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
       if($request['con_detprubas'] !== null){
         $update = \DB::table('empresas_pruebas_base_detalle') ->where('con_detprubas', $request['con_detprubas']) ->limit(1) ->update( [ 'con_comp' => $request['con_comp']]);  
       }
       else{
         $empresas = EmpresasPruebasBaseDetalle::create($request->all());  
       }

       if($request['con_comp'] !== null){
        return Redirect::to('admin/emp_pru_base_detalle/'.$request['con_comp']);
       }
       else{
       return Redirect::to('admin/emp_pru_base_detalle'); 
       }
        
    }
    
    public function delete($id)
    {
        DB::table('empresas_pruebas_base_detalle')->where('con_detprubas', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
    
    
    
    
}
