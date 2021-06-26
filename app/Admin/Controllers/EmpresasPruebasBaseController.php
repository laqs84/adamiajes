<?php

namespace App\Admin\Controllers;

Use App\Models\Empresas;
Use App\Models\EmpresasPruebasBase;
Use App\Models\CompetenciasTipos;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Redirect;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Arr;

class EmpresasPruebasBaseController extends Controller
{
    public function index(){
        
        $empresas = Empresas::all();
        $EmpresasPruebasBase = EmpresasPruebasBase::all();
        $competenciasTipos = CompetenciasTipos::all();
        $empresaspb_arr = array();
        foreach ($empresas as $key => $value) {
           $competenciasTipo = CompetenciasTipos::where('con_tipo', $value['puntaje_base'])->get();
           $empresaspb_item = array(
            "con_emp" => $value['con_emp'] ? $value['con_emp'] : "No hay dato",
            "con_test" => $value['con_test'] ? $value['con_test'] : "No hay dato",
            "descripcion" => $value['descripcion'] ? $value['descripcion'] : "No hay dato",
            "con_tipo" => $value['con_tipo'] ? $value['con_tipo'] : "No hay dato",
            "usa_allcompdis" => $value['usa_allcompdis'] ? $value['usa_allcompdis'] : "No hay dato",            
            "acciones" => '<a style="font-size: 16px;color:green;" href="#" onclick="detalle(this)" class="detalle-' . $value['con_test'] . '"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" href="#" onclick="eliminar(this)" class="eliminar-' . $value['con_test'] . '"><i class="fa fa-trash"></i></a> | <a href="#" onclick="exccomp(this)" class="comp-' . $value['con_test'] . '">Indicar competencia excluida</a>'
        );
        array_push($empresaspb_arr, $empresaspb_item);
        }
        
        return view('admin.empresaspruebasbase' , ['empresaspruebasbase' => $empresas_arr, 'competenciasTipos' => $competenciasTipos, 'empresas' => $empresas, '_user_'      => $this->getUserData()]);
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
       if($request['con_test'] !== NULL){
         $update = \DB::table('empresas_pruebas_base') ->where('con_test', $request['con_test']) ->limit(1) ->update( [ 'descripcion' => $request['descripcion'], 'con_tipo' => $request['con_tipo'], 'usa_allcompdis' => $request['usa_allcompdis']]);  
       }
       else{
         $empresas = EmpresasPruebasBase::create($request->all());  
         
       }

        return Redirect::to('admin/empresas_pruebas_base');
    }
    
    public function delete($id)
    {
        DB::table('empresas_pruebas_base')->where('con_test', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
    
    
    
    
}
