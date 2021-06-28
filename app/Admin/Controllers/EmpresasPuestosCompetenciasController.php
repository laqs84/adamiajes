<?php

namespace App\Admin\Controllers;

Use App\Models\Empresas;
Use App\Models\EmpresasPuestosCompetencias;
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

class EmpresasPuestosCompetenciasController extends Controller
{
    public function index(Request $request){
        
        if($request["id"]){
            $empresasPuestosCompetencias = EmpresasPuestosCompetencias::all();
            $empresasAll = Empresas::where('con_emp', $request["id"])->get();
            $competenciasAll = Competencias::all();
            $competenciasNivelesAll = CompetenciasNiveles::all();
            $puestosAll = Puestos::all();
         
        }
        else{
        
            $empresasPuestosCompetencias = EmpresasPuestosCompetencias::all();
            $empresasAll = Empresas::all();
            $competenciasAll = Competencias::all();
            $competenciasNivelesAll = CompetenciasNiveles::all();
            $puestosAll = Puestos::all();
        }
        $empresas_arr = array();
        foreach ($empresasPuestosCompetencias as $key => $value) {
           $competencias = Competencias::where('con_comp', $value['con_comp'])->get();
           $competenciasNiveles = CompetenciasNiveles::where('con_nivdom', $value['con_nivdom'])->get();
           $puestos = Puestos::where('con_pue', $value['con_pue'])->get();
           $empresas = Empresas::where('con_emp', $value['con_emp'])->get();
           $empresas_item = array(
            "con_emp" => $empresas[0]['descripcion'] ? $empresas[0]['descripcion'] : "No hay dato",
            "con_pue" => $puestos[0]['descripcion'] ? $puestos[0]['descripcion'] : "No hay dato",
            "con_comp" => $competencias[0]['descripcion'] ? $competencias[0]['descripcion'] : "No hay dato",
            "con_nivdom" => $competenciasNiveles[0]['descripcion'] ? $competenciasNiveles[0]['descripcion'] : "No hay dato",
            "acciones" => '<a style="font-size: 16px;color:green;" href="#" onclick="detalle(this)" class="detalle-' . $value['con_emp_pue_comp'] . '"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" href="#" onclick="eliminar(this)" class="eliminar-' . $value['con_emp_pue_comp'] . '"><i class="fa fa-trash"></i></a>'
        );
          // var_dump($value['con_pue']);
       array_push($empresas_arr, $empresas_item);
        }
        
        //var_dump($competenciasNivelesAll);
        
       return view('admin.empresaspuestoscompetencias' , ['empresaspuestoscompetencias' => $empresas_arr, 'competencias' => $competenciasAll, 'empresas' => $empresasAll, 'competenciasNiveles' => $competenciasNivelesAll, 'puestos' => $puestosAll, '_user_'      => $this->getUserData()]);
   }
   
   public function getDetalles($con_emp=0,$con_pue=0){
     $empresasPuestosCompetencias = EmpresasPuestosCompetencias::where('con_emp', $con_emp)->where('con_pue', $con_pue)->get();
     $empresas_arr = array();
     foreach ($empresasPuestosCompetencias as $key => $value) {
       $competencias = Competencias::where('con_comp', $value['con_comp'])->get();
       $competenciasNiveles = CompetenciasNiveles::where('con_nivdom', $value['con_nivdom'])->get();
       $puestos = Puestos::where('con_pue', $value['con_pue'])->get();
       $empresas = Empresas::where('con_emp', $value['con_emp'])->get();
       $empresas_item = array(
        "con_emp" => $empresas[0]['descripcion'] ? $empresas[0]['descripcion'] : "No hay dato",
        "con_pue" => $puestos[0]['descripcion'] ? $puestos[0]['descripcion'] : "No hay dato",
        "con_comp" => $competencias[0]['descripcion'] ? $competencias[0]['descripcion'] : "No hay dato",
        "con_nivdom" => $competenciasNiveles[0]['descripcion'] ? $competenciasNiveles[0]['descripcion'] : "No hay dato",
        "acciones" => '<a style="font-size: 16px;color:green;" href="#" onclick="detalle(this)" class="detalle-' . $value['con_emp_pue_comp'] . '"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" href="#" onclick="eliminar(this)" class="eliminar-' . $value['con_emp_pue_comp'] . '"><i class="fa fa-trash"></i></a>'
        );
          // var_dump($value['con_pue']);
       array_push($empresas_arr, $empresas_item);
     }
$json_data = array(
      "draw"            => intval( 4 ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal"    => intval( 4 ),  // total number of records
      "recordsFiltered" => intval( 4 ), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data"            => $empresas_arr   // total data array
      );

echo json_encode($json_data);  // send data as json format     
     // return $empresas_arr;
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
       if($request['con_emp_pue_comp'] !== null){
         $update = \DB::table('empresas_puestos_competencias') ->where('con_emp_pue_comp', $request['con_emp_pue_comp']) ->limit(1) ->update( [ 'con_emp' => $request['con_emp'], 'con_pue' => $request['con_pue'], 'con_comp' => $request['con_comp'], 'con_nivdom' => $request['con_nivdom']]);  
       }
       else{
         $empresas = EmpresasPuestosCompetencias::create($request->all());  
       }

        return Redirect::to('admin/empresaspuestoscompetencias');
    }
    
    public function delete($id)
    {
        DB::table('empresas_puestos_competencias')->where('con_emp_pue_comp', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
    
    
    
    
}
