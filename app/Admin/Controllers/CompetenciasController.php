<?php

namespace App\Admin\Controllers;

Use App\Models\Competencias;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Arr;
Use App\Models\CompetenciasTipos;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Redirect;

class CompetenciasController extends Controller
{
    public function index(){
        
        $competenciasTipos = CompetenciasTipos::all();
        $competencias = Competencias::all();
        
        
        
        $acciones = '';
        $competencias_arr = array();
        foreach ($competencias as $key => $value) {
            $competenciasTipo = CompetenciasTipos::where('con_tipo', $value['con_tipo'])->get();
            $competencias_item = array(
            "descripcion" => $value['descripcion'] ? $value['descripcion'] : "No hay dato",
            "con_tipo" => $competenciasTipo[0]['descripcion'] ? $competenciasTipo[0]['descripcion'] : "No hay dato",
            "acciones" => '<a style="font-size: 16px;color:green;" title="Editar" href="#" onclick="detalle(this)" class="detalle-' . $value['con_comp'] . '"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" title="Eliminar" href="#" onclick="eliminar(this)" class="eliminar-' . $value['con_comp'] . '"><i class="fa fa-trash"></i></a> | <a href="#" onclick="pregunta(this)" class="pregunta-' . $value['con_comp'] . '">Crear una pregunta</a>'        );
        array_push($competencias_arr, $competencias_item);
        }
        
        return view('admin.competencias' , ['competenciasTipos' => $competenciasTipos, 'competencias' => $competencias_arr, '_user_'      => $this->getUserData()]);
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
       if($request['con_comp'] !== null){
         $update = \DB::table('competencias') ->where('con_comp', $request['con_comp']) ->limit(1) ->update( [ 'descripcion' => $request['descripcion'], 'con_tipo' => $request['con_tipo']]);  
       }
       else{
         $competencias = Competencias::create($request->all());  
       }

        return Redirect::to('admin/competencias');
    }
    
    public function delete($id)
    {
        DB::table('competencias')->where('con_comp', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
    
    
    
    
}
