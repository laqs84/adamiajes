<?php

namespace App\Admin\Controllers;

Use App\Models\Recomendaciones;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Redirect;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Arr;

class RecomendacionesController extends Controller
{
    public function index(Request $request){
        
        if($request["id"]){
            $recomendaciones = Recomendaciones::where('con_puntaje', $request["id"])->get();
            
         
        }
        else{
        
            $recomendaciones = Recomendaciones::all();
            
        }
        $Clasificaciones = \App\Models\CalificacionResultados::all();
        $recomendacion_arr = array();
        foreach ($recomendaciones as $key => $value) {
            $Clasificacion = \App\Models\CalificacionResultados::where('con_puntaje', $value["con_puntaje"])->get();
            if(empty($Clasificacion)){
                $Clasificacion1 = "No hay dato";
            }
            else{
                $Clasificacion1 = $Clasificacion->pluck("recomendacion")->first();
            }
            
            $recomendacion_item = array(
            "con_puntaje" => $Clasificacion1 ? $Clasificacion1 : "No hay dato",
            "detalle_recomendacion" => $value['detalle_recomendacion'] ? $value['detalle_recomendacion'] : "No hay dato",
            "acciones" => '<a style="font-size: 16px;color:green;" href="#" onclick="detalle(this)" class="detalle-' . $value['consecutivo_recomendacion'] . '"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" href="#" onclick="eliminar(this)" class="eliminar-' . $value['consecutivo_recomendacion'] . '"><i class="fa fa-trash"></i></a>'
        );
        array_push($recomendacion_arr, $recomendacion_item);
        }
        
        return view('admin.recomendaciones' , ['recomendaciones' => $recomendacion_arr, 'clasificaciones' => $Clasificaciones, '_user_'      => $this->getUserData()]);
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
       if($request['consecutivo_recomendacion'] !== null){
         $update = \DB::table('cal_res_recomendaciones') ->where('consecutivo_recomendacion', $request['consecutivo_recomendacion']) ->limit(1) ->update( [ 'detalle_recomendacion' => $request['detalle_recomendacion'], 'consecutivo_recomendacion' => $request['consecutivo_recomendacion'] ]);  
       }
       else{
         $recomendaciones = Recomendaciones::create($request->all());  
       }

        return Redirect::to('admin/recomendaciones');
    }
    
    public function delete($id)
    {
        DB::table('cal_res_recomendaciones')->where('consecutivo_recomendacion', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
    
    
    
    
}
