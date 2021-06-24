<?php

namespace App\Admin\Controllers;

Use App\Models\Competencias;
Use App\Models\Preguntas;
Use App\Models\PreguntasOpciones;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Redirect;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Arr;

class PreguntasOpcionesController extends Controller
{
    public function index(Request $request){
        
        if($request["id"]){
         $competencias = Competencias::where('con_comp', $request["id"])->get();
         $preguntas= Preguntas::where('con_preg', $request["idpreg"])->get();
         $preguntasopciones= PreguntasOpciones::where('con_preg', $request["idpreg"])->get();
        }
        else{
        $competencias = Competencias::all();
        $preguntas = Preguntas::all();
        $preguntasopciones= PreguntasOpciones::all();
        }
        
        $acciones = '';
        $preguntas_arr = array();
        foreach ($preguntasopciones as $key => $value) {
            $competencia = Competencias::where('con_comp', $value['con_comp'])->get();
            $pregunta= Preguntas::where('con_preg', $value['con_preg'])->get();
            $preguntas_item = array(
            "descripcion" => $value['descripcion'] ? $value['descripcion'] : "No hay dato",
            "val_asiopci" => $value['val_asiopci'] ? $value['val_asiopci'] : "No hay dato",
            "con_comp" => $competencia[0]['descripcion'] ? $competencia[0]['descripcion'] : "No hay dato",
            "con_preg" => $pregunta[0]['descripcion'] ? $pregunta[0]['descripcion'] : "No hay dato",
            "acciones" => '<a style="font-size: 16px;color:green;" href="#" onclick="detalle(this)" class="detalle-' . $value['con_opci'] . '"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" href="#" onclick="eliminar(this)" class="eliminar-' . $value['con_opci'] . '"><i class="fa fa-trash"></i></a>'
        );
        array_push($preguntas_arr, $preguntas_item);
        }
        
        return view('admin.preguntasopciones' , ['competencias' => $competencias, 'preguntasOpciones' => $preguntas_arr, 'preguntas' => $preguntas, '_user_'      => $this->getUserData()]);
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
       if($request['con_opci'] !== null){
         $update = \DB::table('competencias_preguntas_opciones') ->where('con_opci', $request['con_opci']) ->limit(1) ->update( [ 'descripcion' => $request['descripcion'], 'val_asiopci' => $request['val_asiopci'], 'con_comp' => $request['con_comp'], 'con_preg' => $request['con_preg']]);  
       }
       else{
         $preguntas = PreguntasOpciones::create($request->all());  
       }

       if($request['con_comp'] !== null){
        return Redirect::to('admin/preguntas-opciones/'.$request['con_comp'].'/'.$request['con_preg']);
       }
       else{
        return Redirect::to('admin/preguntas-opciones');   
       }
    }
    
    public function delete($id)
    {
        DB::table('competencias_preguntas_opciones')->where('con_opci', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
    
    
    
    
}
