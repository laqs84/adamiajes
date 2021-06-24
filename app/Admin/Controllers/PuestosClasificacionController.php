<?php

namespace App\Admin\Controllers;

Use App\Models\Puestos;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Redirect;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Arr;

class PuestosClasificacionController extends Controller
{
    public function index(){
        
       
        
        $puestosClasificacion = \App\Models\PuestosClasificacion::all();
        
        $puestos_arr = array();
        foreach ($puestosClasificacion as $key => $value) {
            
            $puestos_item = array(
            "descripcion" => $value['descripcion'] ? $value['descripcion'] : "No hay dato",
            "acciones" => '<a style="font-size: 16px;color:green;" href="#" onclick="detalle(this)" class="detalle-' . $value['con_clapue'] . '"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" href="#" onclick="eliminar(this)" class="eliminar-' . $value['con_clapue'] . '"><i class="fa fa-trash"></i></a>'
        );
        array_push($puestos_arr, $puestos_item);
        }
        
        return view('admin.puestosclasificaciones' , ['puestosClasificacion' => $puestosClasificacion, 'puestos' => $puestos_arr, '_user_'      => $this->getUserData()]);
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
       if($request['con_clapue'] !== null){
         $update = \DB::table('puestos_clasificacion') ->where('con_clapue', $request['con_clapue']) ->limit(1) ->update( [ 'descripcion' => $request['descripcion']]);  
       }
       else{
         $competencias = \App\Models\PuestosClasificacion::create($request->all());  
       }

        return Redirect::to('admin/puestosclasificaciones');
    }
    
    public function delete($id)
    {
        DB::table('puestos_clasificacion')->where('con_clapue', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
    
    
    
    
}
