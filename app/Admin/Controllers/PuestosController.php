<?php

namespace App\Admin\Controllers;

Use App\Models\Puestos;
Use App\Models\CompetenciasTipos;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Redirect;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Arr;

class PuestosController extends Controller
{
    public function index(){
        
       
        $puestos = Puestos::all();
        
        $puestosClasificacion = \App\Models\PuestosClasificacion::all();
        
        $puestos_arr = array();
        foreach ($puestos as $key => $value) {
            $puestosClasificacion1 = \App\Models\PuestosClasificacion::where('con_clapue', $value['con_clapue'])->get();
            $puestos_item = array(
            "descripcion" => $value['descripcion'] ? $value['descripcion'] : "No hay dato",
            "con_clapue" => $puestosClasificacion1[0]['descripcion'] ? $puestosClasificacion1[0]['descripcion'] : "No hay dato",
            "acciones" => '<a style="font-size: 16px;color:green;" href="#" onclick="detalle(this)" class="detalle-' . $value['con_pue'] . '"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" href="#" onclick="eliminar(this)" class="eliminar-' . $value['con_pue'] . '"><i class="fa fa-trash"></i></a>'
        );
        array_push($puestos_arr, $puestos_item);
        }
        
        return view('admin.puestos' , ['puestosClasificacion' => $puestosClasificacion, 'puestos' => $puestos_arr, '_user_'      => $this->getUserData()]);
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
       if($request['con_pue'] !== null){
         $update = \DB::table('puestos') ->where('con_pue', $request['con_pue']) ->limit(1) ->update( [ 'descripcion' => $request['descripcion'], 'con_clapue' => $request['con_clapue']]);  
       }
       else{
         $competencias = Puestos::create($request->all());  
       }

        return Redirect::to('admin/puestos');
    }
    
    public function delete($id)
    {
        DB::table('puestos')->where('con_pue', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
    
    
    
    
}
