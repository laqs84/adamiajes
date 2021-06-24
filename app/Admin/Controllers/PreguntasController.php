<?php

namespace App\Admin\Controllers;

Use App\Models\Competencias;
Use App\Models\Preguntas;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Redirect;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Arr;

class PreguntasController extends Controller
{
    public function index(Request $request){
        
        if($request["id"]){
         $competencias = Competencias::where('con_comp', $request["id"])->get();
         $preguntas= Preguntas::where('con_comp', $request["id"])->get();
        }
        else{
        $competencias = Competencias::all();
        $preguntas = Preguntas::all();
        }
        
        $acciones = '';
        $preguntas_arr = array();
        foreach ($preguntas as $key => $value) {
            $competencia = Competencias::where('con_comp', $value['con_comp'])->get();
            $preguntas_item = array(
            "descripcion" => $value['descripcion'] ? $value['descripcion'] : "No hay dato",
            "con_comp" => $competencia[0]['descripcion'] ? $competencia[0]['descripcion'] : "No hay dato",
            "acciones" => '<a style="font-size: 16px;color:green;" href="#" onclick="detalle(this)"  class="detalle-' . $value['con_preg'] . '"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" href="#" onclick="eliminar(this)" class="eliminar-' . $value['con_preg'] . '"><i class="fa fa-trash"></i></a> | <a href="#" onclick="pregunta(this)" data-pregunta="' . $value['con_preg'] . '" class="pregunta-' . $value['con_comp'] . '">Crear las opciones de la pregunta</a>'
        );
        array_push($preguntas_arr, $preguntas_item);
        }
        
        return view('admin.preguntas' , ['competencias' => $competencias, 'preguntas' => $preguntas_arr, '_user_'      => $this->getUserData()]);
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
       if($request['con_preg'] !== null){
         $update = \DB::table('competencias_preguntas') ->where('con_preg', $request['con_preg']) ->limit(1) ->update( [ 'descripcion' => $request['descripcion'], 'con_comp' => $request['con_comp']]);  
       }
       else{
         $preguntas = Preguntas::create($request->all());  
       }

       if($request['con_comp'] !== null){
        return Redirect::to('admin/preguntas/'.$request['con_comp']);
       }
       else{
        return Redirect::to('admin/preguntas');   
       }
    }
    
    public function delete($id)
    {
        DB::table('competencias_preguntas')->where('con_preg', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
    
    
    
    
}
