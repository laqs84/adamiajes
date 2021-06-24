<?php

namespace App\Admin\Controllers;

Use App\Models\Empresas;
Use App\Models\EmpresasCompetenciasNiveldominio;
Use App\Models\CompetenciasNiveles;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Redirect;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Arr;

class EmpresasNivelesController extends Controller
{
    public function index(){
        
       
        $empresasNiveles = \App\Models\EmpresasCompetenciasNiveldominio::all();
        
        $competenciasTipos = CompetenciasNiveles::all();
        
        $empresasAll = Empresas::all();
        
        $empresasniveles_arr = array();
        foreach ($empresasNiveles as $key => $value) {
            $competenciasTipo = CompetenciasNiveles::where('con_nivdom', $value['con_nivdom'])->get();
            $empresas = Empresas::where('con_emp', $value['con_emp'])->get();
            $empresasniveles_item = array(
            "con_emp" => $empresas[0]['descripcion'] ? $empresas[0]['descripcion'] : "No hay dato",
            "con_nivdom" => $competenciasTipo[0]['descripcion'] ? $competenciasTipo[0]['descripcion'] : "No hay dato",
            "valor_esperado" => $value['valor_esperado'] ? $value['valor_esperado'] : "No hay dato",
            "acciones" => '<a style="font-size: 16px;color:green;" href="#" onclick="detalle(this)" class="detalle-' . $value['con_nivdom'] . '"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" href="#" onclick="eliminar(this)" class="eliminar-' . $value['con_nivdom'] . '"><i class="fa fa-trash"></i></a>'
        );
        array_push($empresasniveles_arr, $empresasniveles_item);
        }
        
        return view('admin.empresasniveles' , ['empresasTipos' => $empresasniveles_arr, 'empresasNiveles' => $empresasNiveles, 'competenciasTipos' => $competenciasTipos, 'empresas' => $empresasAll, '_user_'      => $this->getUserData()]);
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
       if($request['con_comp_niv'] !== null){
         $update = \DB::table('empresas_competencias_niveldominio') ->where('con_comp_niv', $request['con_comp_niv']) ->limit(1) ->update( [ 'con_emp' => $request['con_emp'], 'con_nivdom' => $request['con_nivdom'], 'valor_esperado' => $request['valor_esperado']]);  
       }
       else{
         $competencias = EmpresasCompetenciasNiveldominio::create($request->all());  
       }

        return Redirect::to('admin/empresasniveles');
    }
    
    public function delete($id)
    {
        DB::table('empresas_competencias_niveldominio')->where('con_comp_niv', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
    
    
    
    
}
