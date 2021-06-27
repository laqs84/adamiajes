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
        foreach ($EmpresasPruebasBase as $key => $value) {
           $competenciasTipo = CompetenciasTipos::where('con_tipo', $value['con_tipo'])->get();
           $empresaspb_item = array(
            "descripcion" => $value['descripcion'] ? $value['descripcion'] : "No hay dato",
            "instrucciones" => $value['instrucciones'] ? $value['instrucciones'] : "No hay dato",            
            "con_tipo" => $value['con_tipo'] ? $value['con_tipo'] : "No hay dato",
            "usa_allcompdis" => $value['usa_allcompdis'] ? $value['usa_allcompdis'] : "No hay dato",                                  
            "acciones" => '<a style="font-size: 16px;color:green;" href="#" onclick="detalle(this)" class="detalle-' . $value['con_test'] . '"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" href="#" onclick="eliminar(this)" class="eliminar-' . $value['con_test'] . '"><i class="fa fa-trash"></i></a> | <a href="#" onclick="exc_comp(this)" class="comp-' . $value['con_test'] . '">Indicar competencia excluida</a>'
        );
        array_push($empresaspb_arr, $empresaspb_item);
        }
        
        return view('admin.empresas_pruebas_base' , ['empresas_pruebas_base' => $empresaspb_arr, 'CompetenciasTipos' => $competenciasTipos, 'empresas' => $empresas, '_user_'      => $this->getUserData()]);
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
         $update = \DB::table('empresas_pruebas_base') ->where('con_test', $request['con_test']) ->limit(1) ->update( [ 'descripcion' => $request['descripcion'], 'con_tipo' => $request['con_tipo'], 'usa_allcompdis' => $request['usa_allcompdis'], 'instrucciones' => $request['instrucciones']]);  
       }
       else{
         $EmpresasPruebasBase = EmpresasPruebasBase::create($request->all());  
         
       }

        return Redirect::to('admin/empresas_pruebas_base');
    }
    
    public function delete($id)
    {
        DB::table('empresas_pruebas_base')->where('con_test', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
    
    
    
    
}
