<?php

namespace App\Admin\Controllers;

Use App\Models\Empresas;
Use App\Models\EmpresaPruebas;
Use App\Models\PersonasPruebas;
Use App\Models\Personas;
Use App\Models\Competencias;
Use App\Models\CompetenciasNiveles;
Use App\Models\EmpresasCompetenciasNiveldominio;
Use App\Models\Puestos;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Redirect;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Arr;

class PersonaPruebasAddController extends Controller
{
    public function index(Request $request){
        
        if($request["id"]){
      
            $empresaPruebas = EmpresaPruebas::where('numsec_prueba', $request["id"])->get();
            $con_emp = $empresaPruebas[0]->con_emp;
            $titulo = "Candidatos a incluir en la prueba";
            $PersonasPruebas = PersonasPruebas::where('numsec_prueba', $request["id"])->get();
         
        }
        else{
        
            $PersonasPruebas = PersonasPruebas::where('numsec_prueba', $request["id"])->get();
            $con_emp = 0;
            $titulo = "";
            $empresasAll = Empresas::all();
            $competenciasAll = Competencias::all();
           
            // $competenciasNivelesAll = CompetenciasNiveles::all();
            // $puestosAll = Puestos::all();
        }
        $personas_arr = array();
        $personas_item = array();
        foreach ($PersonasPruebas as $key => $value) {
        
           $persona = Personas::where('con_persona', $value['con_persona'])->get();

           $nombre = $persona[0]['nombres'] . " " . $persona[0]['apellido1'];
           $empresas = Empresas::where('con_emp', $value['con_emp'])->get();
           $personas_item = array(
            "link_pru" => $value['link_pru'] ? $value['link_pru'] : "No hay dato",
            "numsec_prueba" => $value['numsec_prueba'] ? $value['numsec_prueba'] : "No hay dato",
            "con_persona" => $persona[0]['nombres'] ? $persona[0]['nombres'] : "No hay dato",            
            "acciones" => '</a> | <a style="font-size: 16px; color:red;" href="#" onclick="eliminar(this)" class="eliminar-' . $value['num_pruper'] . '"><i class="fa fa-trash"></i></a>'
        );
          // var_dump($value['con_pue']);
     
            array_push($personas_arr, $personas_item);
       
       
        }
        

        
       return view('admin.persona_pruebas_add' , ['persona_pruebas' => $personas_arr,'con_emp' => $con_emp,  'numsec_prueba' => $request["id"],  'titulo' => $titulo, '_user_'  => $this->getUserData()]);
   }

   public function getPersonas(Request $request){

        $search = $request->search;
        $numsec_prueba = $request->numsec_prueba;


        $EmpresaPruebas = EmpresaPruebas::where('numsec_prueba', $numsec_prueba)->get();
        $con_emp = $EmpresaPruebas[0]['con_emp'];
        $Personas = Personas::where('con_emp', $con_emp)
                    ->whereNOTIn('con_persona',function($query) use($numsec_prueba) {
               $query->select('con_persona')->from('personas_pruebas')->where('numsec_prueba',$numsec_prueba);
            })->get();



        $personas_arr = array();
        $test = 0;
        $descripcion = "";
        $instrucciones = "";
        $return_arr = array();
        foreach ($Personas as $key => $value) {
          $nombre = $value['nombres'] . " " . $value['apellido1'];
          $return_arr[] = array("id" => $value['con_persona'],
                    "text" => $nombre . " " . $value['email']);
        }
        return response()->json($return_arr);
       
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
       $rand = mt_rand();
       $random = $request['con_persona'] . "-" . $rand;
       $link = "https://andamiajescr.com/admin/personas_pruebas/".$random;
       if($request['con_detpru'] !== null){
         $update = \DB::table('persona_pruebas') ->where('con_persona', $request['con_persona']) ->limit(1) ->update( [ 'con_test' => $request['con_test']]);  
       }
       else{
         $empresas = PersonasPruebas::create($request->all());  
         $id = $empresas->id;
         var_dump($id);
         $update = \DB::table('personas_pruebas') ->where('num_pruper', $id) ->limit(1) ->update( [ 'random_pru' => $random, 'link_pru' => $link]);           
       }

 
        return Redirect::to('admin/persona_pruebas_add/'.$request['numsec_prueba']);

        
    }
    
    public function delete($id)
    {
        DB::table('personas_pruebas')->where('num_pruper', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
    
    
    
    
}
