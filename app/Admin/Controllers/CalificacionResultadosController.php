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
            $Competencia1 = Competencias::where('con_comp', $value['con_comp'])->get();
            if($value['tipo_puntuacion'] == "PC"){
                $tipo_puntuacion = "Por Competencia";
            }
            if($value['tipo_puntuacion'] == "PTC"){
                $tipo_puntuacion = "Por total de competencias";
            } 
            if($value['tipo_puntuacion'] == "PNEL"){
                $tipo_puntuacion = "Por niveles esperados logrados";
            }
            if($value['aplicar_rr_no_ni'] == "on"){
                $aplicar_rr_no_ni = "Si";
            }
            else{
                $aplicar_rr_no_ni = "No";
            }
            
            $CalificacionResultados_item = array(
            "con_tipo" => $CompetenciasTipo->pluck("descripcion")->first() ? $CompetenciasTipo->pluck("descripcion")->first() : "No hay dato",
            "tipo_puntuacion" => $tipo_puntuacion ? $tipo_puntuacion : "No hay dato",
            "con_comp" => $Competencia1->pluck("descripcion")->first() ? $Competencia1->pluck("descripcion")->first() : "Ninguna",
            "rango_inicial" => $value['rango_inicial'] ? $value['rango_inicial'] : "No hay dato",
            "rango_final" => $value['rango_final'] ? $value['rango_final'] : "No hay dato",
            "aplicar_rr_no_ni" => $aplicar_rr_no_ni ? $aplicar_rr_no_ni : "No hay dato",
            "aciones" => '<a style="font-size: 16px;color:green;" title="Editar" href="#" onclick="detalle(this)" class="detalle-'.$value['con_puntaje'].'"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" title="Eliminar" href="#" onclick="eliminar(this)" class="eliminar-'.$value['con_puntaje'].'"><i class="fa fa-trash"></i></a> | <a href="#" onclick="pregunta(this)" class="recomendacion-'.$value['con_puntaje'].'">Crear una recomendacion</a>');
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


      $resultados = Competencias::where('con_tipo', $con_tipo)->get();

      $competenciasData['data'] = $resultados;
      return response()->json($competenciasData);
     
    }
   
   public function store(Request $request)
    {
       if($request['con_puntaje'] !== null){
         $update = \DB::table('calificacion_resultados') ->where('con_puntaje', $request['con_puntaje']) ->limit(1) ->update( [ 'con_comp' => $request['con_comp'], 'con_tipo' => $request['con_tipo'], 'tipo_puntuacion' => $request['tipo_puntuacion'], 'rango_inicial' => $request['rango_inicial'], 'rango_final' => $request['rango_final'], 'predominancia_resultado' => $request['predominancia_resultado'], 'resultado_descriptivo' => $request['resultado_descriptivo'], 'comportamiento_descriptivo' => $request['comportamiento_descriptivo'], 'recomendacion' => $request['recomendacion'], 'aplicar_rr_no_ni' => $request['aplicar_rr_no_ni']]);  
       }
       else{
         $CalificacionResultados = CalificacionResultados::create($request->all());  
       }

        return Redirect::to('admin/calificacion_resultados');
    }
    
    public function delete($id)
    {
        DB::table('calificacion_resultados')->where('con_puntaje', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
    
    
    
    
}
