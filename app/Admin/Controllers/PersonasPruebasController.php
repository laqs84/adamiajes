<?php

namespace App\Admin\Controllers;

Use App\Models\Empresas;
Use App\Models\EmpresaPruebas;
Use App\Models\EmpresaPruebasDetalle;
Use App\Models\EmpresasPruebasBase;
Use App\Models\EmpresasPruebasBaseDetalle;
use App\Models\Competencias;

Use App\Models\PersonasPruebas;
Use App\Models\PersonasPruebasDetalle;
Use App\Models\Puestos;
Use App\Models\Personas;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Redirect;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Arr;

class PersonasPruebasController extends Controller
{
    public function index($random_pru=""){

        $PersonasPruebas = PersonasPruebas::where('random_pru', $random_pru)->get();
        $numsec_prueba = $PersonasPruebas->pluck("numsec_prueba")->first();
        $num_pruper = $PersonasPruebas->pluck("num_pruper")->first();
        $con_persona = $PersonasPruebas->pluck("con_persona")->first();
        $Personas = Personas::where('con_persona', $con_persona)->get();
        $nom = $Personas->pluck("nombres")->first();
        $ap1 = $Personas->pluck("apellido1")->first();
        $nombre = $nom . " " . $ap1;
        $EmpresaPruebas = EmpresaPruebas::where('numsec_prueba', $numsec_prueba)->get();
        $con_emp = $EmpresaPruebas->pluck("con_emp")->first();
        $conpue = $EmpresaPruebas->pluck("con_pue")->first();
        $tiempo_limite = $EmpresaPruebas->pluck("tiempo_limite")->first() . " minutos";
        $EmpresaPruebasDetalle = EmpresaPruebasDetalle::where('numsec_prueba', $numsec_prueba)->get();
        $empresas = Empresas::where('con_emp', $con_emp)->get();
        $empresa = $empresas->pluck("descripcion")->first();
        $puestos = Puestos::where('con_pue', $conpue)->get();
        $puesto =  $puestos->pluck("descripcion")->first();

        


        // $empresasp_arr = array();
        // foreach ($EmpresaPruebas as $key => $value) {

        //    $puestos = Puestos::where('con_pue', $value['con_pue'])->get();
        //    $empresasp_item = array(
        //     "descripcion" => $value['descripcion'] ? $value['descripcion'] : "No hay dato",
        //     "con_pue" => $puestos[0]['descripcion'] ? $puestos[0]['descripcion']  : "No hay dato",            
        //     "fecha_inicio" => $value['fecha_inicio'] ? $value['fecha_inicio'] : "No hay dato",                       
        //     "fecha_limite" => $value['fecha_limite'] ? $value['fecha_limite'] : "No hay dato",            
        //     "tiempo_limite" => $value['tiempo_limite'] ? $value['tiempo_limite'] : "No hay dato",                                    
        //     "acciones" => '<a style="font-size: 16px;color:green;" href="#" onclick="detalle(this)" class="detalle-' . $value['numsec_prueba'] . '"><i class="fa fa-edit"></i></a> | <a style="font-size: 16px; color:red;" href="#" onclick="eliminar(this)" class="eliminar-' . $value['numsec_prueba'] . '"><i class="fa fa-trash"></i></a> | <a href="#" onclick="agrega_test(this)" class="comp-' . $value['numsec_prueba'] . '">Agregar Test</a>'
        // );
        // array_push($empresasp_arr, $empresasp_item);
        // }
 
        return view('admin.personas_pruebas' , ['numsec_prueba' => $numsec_prueba, 
                                                'num_pruper' => $num_pruper, 
                                                'puesto' => $puesto, 
                                                'con_persona' => $con_persona, 
                                                'tiempo_limite' => $tiempo_limite, 
                                                'empresa' => $empresa, 
                                                'con_test' => 0,
                                                'con_emp' => $con_emp, 
                                                'nombre' => $nombre, 
                                                'instrucciones' => '', 
                                                'descripcion' => '',
                                                'random_pru' => $random_pru,
                                                'test' => 0,
                                                '_user_' => $this->getUserData()]);
   }
   public function test($random_pru=""){

        $PersonasPruebas = PersonasPruebas::where('random_pru', $random_pru)->get();
        $numsec_prueba = $PersonasPruebas->pluck("numsec_prueba")->first();
        $num_pruper = $PersonasPruebas->pluck("num_pruper")->first();
        $con_persona = $PersonasPruebas->pluck("con_persona")->first();
        $Personas = Personas::where('con_persona', $con_persona)->get();
        $nom = $Personas->pluck("nombres")->first();
        $ap1 = $Personas->pluck("apellido1")->first();
        $nombre = $nom . " " . $ap1;     
        $EmpresaPruebas = EmpresaPruebas::where('numsec_prueba', $numsec_prueba)->get();
        $EmpresaPruebasDetalle = EmpresaPruebasDetalle::where('numsec_prueba', $numsec_prueba)->get();
        $con_emp = $EmpresaPruebas[0]['con_emp'];
       
        $conpue = $EmpresaPruebas[0]['con_pue'];
        $tiempo_limite = $EmpresaPruebas[0]['tiempo_limite'] . " minutos";
        $empresas = Empresas::where('con_emp', $con_emp)->get();
        $empresa = $empresas[0]['descripcion'];
        $puestos = Puestos::where('con_pue', $conpue)->get();
        $puesto =  $puestos[0]['descripcion'];

        $pruebas_arr = array();
        $test = 0;
        $descripcion = "";
        $instrucciones = "";
        foreach ($EmpresaPruebasDetalle as $key => $value) {
          $EmpresasPruebasBase = EmpresasPruebasBase::where('con_test', $value['con_test'])->get();
          $test = $value['con_test'];
          $descripcion = $EmpresasPruebasBase[0]['descripcion'];
      
          $instrucciones = $EmpresasPruebasBase[0]['instrucciones'];
          $pruebas_item = array(
            "con_test" => $value['con_test'],
            "descripcion" => $value['descripcion'],
            "instrucciones" => $value['instrucciones'],
            "con_tipo" => $value['con_tipo'],
            "usa_allcompdis" => $value['usa_allcompdis'],
          );
          array_push($pruebas_arr, $pruebas_item);

        }

        return view('admin.personas_pruebas' , 
          ['numsec_prueba' => $numsec_prueba,
          'pruebas_arr' => $pruebas_arr,
          'random_pru' => $random_pru,
          'num_pruper' => $num_pruper,
          'puesto' => $puesto, 
          'con_persona' => $con_persona, 
          'tiempo_limite' => $tiempo_limite, 
          'empresa' => $empresa, 
          'nombre' => $nombre, 
          'con_emp' => $con_emp, 
          'con_test' => $test,
          'pruebas' => $pruebas_arr,
          'instrucciones' => $instrucciones, 
          'descripcion' => $descripcion, 
          '_user_' => $this->getUserData()]);    
   }

    // Fetch records
    public function updatePrueba($con_test=""){

      $ar = json_decode($con_test);
      foreach ($ar as $key => $value) {
        switch ($key) {
          case 'numsec_prueba':
            $numsec_prueba = $value;
            break;
          case 'num_pruper':
            $num_pruper = $value;
            break;            
          case 'con_persona':
            $con_persona = $value;
            break;
          case 'con_emp':
            $con_emp = $value;
            break;
          case 'con_comp':
            $con_comp = $value;
            break;            
          case 'con_persona':
            $con_persona = $value;
            break;                        
          case 'con_test':
            $con_test = $value;
            break;            
          case 'con_preg':
            $con_preg = $value;
            break;
          case 'con_opc':
            $con_opci = $value;

            break;
                                        
          default:
            # code...
            break;
        }

      }
      if($con_preg>0){
      
        $ppd = PersonasPruebasDetalle::create([
         'con_emp' => $con_emp,
         'con_persona' => $con_persona,
         'numsec_prueba' => $numsec_prueba,
         'num_pruper' => $num_pruper,
         'con_test' => $con_test,
         'con_comp' => $con_comp,
         'con_preg' => $con_preg,
         'con_opci' => $con_opci,
        ]);
      }
    }
    // Fetch records
    public function getNextTest($random_pru="",$con_test=""){
        $PersonasPruebas = PersonasPruebas::where('random_pru', $random_pru)->get();
        $numsec_prueba = $PersonasPruebas->pluck("numsec_prueba")->first();
        $con_persona = $PersonasPruebas->pluck("con_persona")->first();
        $EmpresaPruebas = EmpresaPruebas::where('numsec_prueba', $numsec_prueba)->get();
        $EmpresaPruebasDetalle = EmpresaPruebasDetalle::where('numsec_prueba', $numsec_prueba)->get();
        $con_emp = $EmpresaPruebas[0]['con_emp'];
        $conpue = $EmpresaPruebas[0]['con_pue'];
        $tiempo_limite = $EmpresaPruebas[0]['tiempo_limite'] . " minutos";
        $empresas = Empresas::where('con_emp', $con_emp)->get();
        $empresa = $empresas[0]['descripcion'];
        $puestos = Puestos::where('con_pue', $conpue)->get();
        $puesto =  $puestos[0]['descripcion'];
        $pruebas_arr = array();
        $test = 0;
        $descripcion = "";
        $instrucciones = "";
        $str_arr = explode (",", $con_test); 
        foreach ($EmpresaPruebasDetalle as $key => $value) {
          $EmpresasPruebasBase = EmpresasPruebasBase::where('con_test', $value['con_test'])->get();
          $test = $value['con_test'];
          if (in_array($test, $str_arr)){
            continue;
          }
          $descripcion = $EmpresasPruebasBase[0]['descripcion'];
          $instrucciones = $EmpresasPruebasBase[0]['instrucciones'];
          $pruebas_item = array(
            "con_test" => $value['con_test'],
            "descripcion" => $descripcion,
            "instrucciones" => $instrucciones,
            "con_tipo" => $EmpresasPruebasBase[0]['con_tipo'],
            "usa_allcompdis" => $EmpresasPruebasBase[0]['usa_allcompdis'],
          );
          break;

        }
        if(!isset($pruebas_item)){
          $pruebas_item = array(
            "con_test" => 0,
            "descripcion" => "",
            "instrucciones" => "",
            "con_tipo" => "",
            "usa_allcompdis" => "",
          );
        }
        $testData['data'] = $pruebas_item;
        return response()->json($testData);  

    }   
    public function getPreguntas($con_test=0,$numsec_prueba=0){

      $resultados = EmpresasPruebasBase::where('con_test', $con_test)->get();
      if($resultados[0]['con_tipo']==2){
        $empresaPruebas = EmpresaPruebas::where('numsec_prueba', $numsec_prueba)->get();
        $con_pue = intval($empresaPruebas[0]['con_pue']);
        $query = Competencias::select(
            'competencias_preguntas.con_preg',
            'competencias_tipos.tipo_calificacion', 
            'competencias.con_comp', 
            'competencias.descripcion AS competencia_desc',
            'competencias_preguntas.descripcion AS pregunta_desc',
            'competencias_preguntas_opciones.con_opci',
            'competencias_preguntas_opciones.descripcion AS opcion_desc')
           ->join('competencias_tipos','competencias_tipos.con_tipo','=','competencias.con_tipo')  
           ->join("empresas_puestos_competencias",function($join) use($con_pue){

            $join->on("empresas_puestos_competencias.con_comp","=",'competencias.con_comp')
            ->where("empresas_puestos_competencias.con_pue",$con_pue); })
           ->join('competencias_preguntas','competencias_preguntas.con_comp','=','competencias.con_comp')
           ->join('competencias_preguntas_opciones','competencias_preguntas_opciones.con_preg','=','competencias_preguntas.con_preg')       
           ->where('competencias.con_tipo', '=' ,$resultados[0]['con_tipo'])
           ->orderby('competencias.con_comp')
           ->orderby('competencias_preguntas.con_preg')->get(); 
      }
      else{
        $query = Competencias::select(
          'competencias_preguntas.con_preg',
          'competencias_tipos.tipo_calificacion', 
          'competencias.con_comp', 
          'competencias.descripcion AS competencia_desc',
          'competencias_preguntas.descripcion AS pregunta_desc',
          'competencias_preguntas_opciones.con_opci',
          'competencias_preguntas_opciones.descripcion AS opcion_desc')
         ->Join('competencias_tipos','competencias_tipos.con_tipo','=','competencias.con_tipo')      
         ->Join('competencias_preguntas','competencias_preguntas.con_comp','=','competencias.con_comp')
         ->Join('competencias_preguntas_opciones','competencias_preguntas_opciones.con_preg','=','competencias_preguntas.con_preg')       
         ->where('competencias.con_tipo', '=' ,$resultados[0]['con_tipo'])
         ->orderby('competencias.con_comp')
         ->orderby('competencias_preguntas.con_preg')->get();        
      }

      

      $competenciasData['data'] = $query;
      return response()->json($competenciasData);
     
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

       $lastid = 0;
       $random_pru = "";
       if($request['random_pru'] !== NULL){
      
         $random_pru = $request['random_pru'];
         $hourMin = date('H:i');
         $today = date("Y-m-d");
         $update = \DB::table('personas_pruebas') ->where('numsec_prueba', $request['numsec_prueba']) ->limit(1) ->update( [ 'hora_inicio' => $hourMin, 'fecha_prueba' => $today, 'iniciada' => 1]);  
       }
       else{
         $PersonasPruebas= PersonasPruebas::create($request->all());  
         $lastid = $PersonasPruebas->id;
       }

       //return view('admin.personas_pruebas' , ['random_pru' => $random_pru]); 
       return Redirect::to(asset('admin/personas_pruebas/test/'.$random_pru));
       //return redirect()->route('personas_pruebas/test/'.$random_pru);
       //return redirect()->route('personas_pruebas.test', ['id' => $random_pru]);
    }
    
    public function delete($id)
    {
        DB::table('personas_pruebas')->where('num_pruper', '=', $id)->delete();

        return response()->json(null, 204);
    }
    
    
    
    
    
}
