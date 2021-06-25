<?php

namespace App\Admin\Controllers;

Use App\Models\CalificacionResultados;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Arr;
Use App\Models\CompetenciasTipos;
Use App\Models\Competencias;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Redirect;

class CalificacionResultadosController extends Controller
{
    public function index(){
        
        $CompetenciasTipos = CompetenciasTipos::all();
        $Competencias = Competencias::all();
        $CalificacionResultados = CalificacionResultados::all();
        
        
        
        $acciones = '';
        $CalificacionResultados_arr = array();
        foreach ($CalificacionResultados as $key => $value) {
            $CompetenciasTipo = CompetenciasTipos::where('con_tipo', $value['con_tipo'])->get();
            $Competencias = Competencias::where('con_tipo', $value['con_tipo'])->get();
            $CalificacionResultados_item = array(
            "recomendacion" => $value['recomendacion'] ? $value['recomendacion'] : "No hay dato",
            "con_tipo" => $CompetenciasTipo[0]['descripcion'] ? $CompetenciasTipo[0]['descripcion'] : "No hay dato",
            "acciones" => '<a style="font-size: 16px;color:green;" title="Editar" href="#" onclick="detalle(this)" class="detalle-' . $value['con_puntaje'] . '"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" title="Eliminar" href="#" onclick="eliminar(this)" class="eliminar-' . $value['con_puntaje'] . '"><i class="fa fa-trash"></i></a> | <a href="#" onclick="pregunta(this)" class="recomendacion-' . $value['consecutivo_recomendación'] . '">Crear una recomendacion</a>'        );
        array_push($CalificacionResultados_arr, $CalificacionResultados_item);
        }
        
        return view('admin.CalificacionResultados' , ['CompetenciasTipos' => $CompetenciasTipos, 'Competencias' => $Competencias, 'CalificacionResultados' => $CalificacionResultados_arr, '_user_'      => $this->getUserData()]);
   }
   
   protected function getUserData()
    {
        if (!$user = Admin::user()) {
            return [];
        }

        return Arr::only($user->toArray(), ['id', 'username', 'email', 'name', 'avatar']);
    }

    // Fetch records
    public function getCompetencias($con_tipo=0){

        // Fetch Employees by Departmentid
        $competenciasData['data'] = Competencias::orderby("descripcion","asc")
                    ->select('con_comp','descripcion')
                    ->where('con_tipo',$con_tipo)
                    ->get();
  
        return response()->json($competenciasData);
     
    }
   
   public function store(Request $request)
    {
       if($request['con_puntaje'] !== null){
         $update = \DB::table('calificacion_resultados') ->where('con_puntaje', $request['con_puntaje']) ->limit(1) ->update( [ 'descripcion' => $request['descripcion'], 'con_tipo' => $request['con_tipo']]);  
       }
       else{
         $CalificacionResultados = CalificacionResultados::create($request->all());  
       }

        return Redirect::to('admin/CalificacionResultados');
    }
    
    public function delete($id)
    {
        DB::table('CalificacionResultados')->where('con_puntaje', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
    
    
    
    
}
