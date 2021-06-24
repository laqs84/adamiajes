<?php

namespace App\Admin\Controllers;

Use App\Models\Competencias;
Use App\Models\CompetenciasTipos;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Redirect;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Arr;

class CompetenciasNivelesController extends Controller
{
    public function index(){
        
       
        $competenciasNiveles = \App\Models\CompetenciasNiveles::all();
        
        $competenciasTipos = CompetenciasTipos::all();
        
        $competencias_arr = array();
        foreach ($competenciasNiveles as $key => $value) {
            $competenciasTipo = CompetenciasTipos::where('con_tipo', $value['val_nivdom'])->get();
            $competencias_item = array(
            "descripcion" => $value['descripcion'] ? $value['descripcion'] : "No hay dato",
            "val_nivdom" => $value['val_nivdom'] ? $value['val_nivdom'] : "No hay dato",
            "acciones" => '<a style="font-size: 16px;color:green;" href="#" onclick="detalle(this)" class="detalle-' . $value['con_nivdom'] . '"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" href="#" onclick="eliminar(this)" class="eliminar-' . $value['con_nivdom'] . '"><i class="fa fa-trash"></i></a>'
        );
        array_push($competencias_arr, $competencias_item);
        }
        
        return view('admin.competenciasniveles' , ['competenciasTipos' => $competenciasTipos, 'competencias' => $competencias_arr, '_user_'      => $this->getUserData()]);
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
         $update = \DB::table('competencias_niveldominio') ->where('con_nivdom', $request['con_nivdom']) ->limit(1) ->update( [ 'descripcion' => $request['descripcion'], 'val_nivdom' => $request['val_nivdom']]);  
       }
       else{
         $competencias = \App\Models\CompetenciasNiveles::create($request->all());  
       }

        return Redirect::to('admin/competenciasniveles');
    }
    
    public function delete($id)
    {
        DB::table('competencias_niveldominio')->where('con_nivdom', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
    
    
    
    
}
