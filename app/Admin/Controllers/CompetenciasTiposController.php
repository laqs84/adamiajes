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

class CompetenciasTiposController extends Controller
{
    public function index(){
        
        $competenciasTipos = CompetenciasTipos::all();
        $competencias = Competencias::all();
        
        
        
        $acciones = '';
        $competencias_arr = array();
        foreach ($competenciasTipos as $key => $value) {
            $competencias_item = array(
            "descripcion" => $value['descripcion'] ? $value['descripcion'] : "No hay dato",
            "tipo_calificacion" => $value['tipo_calificacion'] ? $value['tipo_calificacion'] : "No hay dato",
            "acciones" => '<a style="font-size: 16px;color:green;" title="Editar" href="#" onclick="detalle(this)" class="detalle-' . $value['con_tipo'] . '"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" title="Eliminar" href="#" onclick="eliminar(this)" class="eliminar-' . $value['con_tipo'] . '"><i class="fa fa-trash"></i></a>');
        array_push($competencias_arr, $competencias_item);
        }
        
        return view('admin.competenciastipos' , ['competencias' => $competencias_arr, '_user_'      => $this->getUserData()]);
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
       if($request['con_nivdom'] !== null){
         $update = \DB::table('competencias_tipos') ->where('con_tipo', $request['con_nivdom']) ->limit(1) ->update( [ 'descripcion' => $request['descripcion'], 'tipo_calificacion' => $request['tipo_calificacion']]);  
       }
       else{
         $competencias = CompetenciasTipos::create($request->all());  
       }

        return Redirect::to('admin/competenciastipos');
    }
    
    public function delete($id)
    {
        DB::table('competencias_tipos')->where('con_tipo', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
    
    
    
    
}
