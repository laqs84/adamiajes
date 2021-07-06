<?php

namespace App\Admin\Controllers;

Use App\Models\Competencias;
Use App\Models\CompetenciasTipos;
Use App\Models\CompetenciasNiveles;
Use App\Models\Preguntas;
Use App\Models\PreguntasOpciones;
Use App\Models\EmpresaPruebas;
Use App\Models\EmpresaPruebasDetalle;
Use App\Models\EmpresasCompetenciasNiveldominio;
Use App\Models\Empresas;
Use App\Models\EmpresasPuestosCompetencias;
Use App\Models\Personas;
Use App\Models\PersonasPruebas;
Use App\Models\PersonasPruebasDetalle;
Use App\Models\PersonasPruebasResultado;
Use App\Models\Puestos;
Use App\Models\PuestosClasificacion;
Use App\Models\CalificacionResultados;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Redirect;
use Exception;
use Barryvdh\DomPDF\Facade as PDF;

class CandidatosPruebasController extends Controller {

    public function index() {

        $request = Admin::user();

        if ($request["con_emp"] !== 0) {

            $empresas = Empresas::where('con_emp', $request["con_emp"])->get();

            $candidatos = PersonasPruebas::where('con_emp', $request["con_emp"])->get();
        } else {


            $candidatos = PersonasPruebas::all();

            $empresas = Empresas::all();
        }

        $candidatos_arr = array();
        foreach ($candidatos as $key => $value) {


            $empresas = Empresas::where('con_emp', $value['con_emp'])->get();
            $empresapruebas = EmpresaPruebas::where('numsec_prueba', $value['numsec_prueba'])->get();
            $idPuesto = $empresapruebas->pluck("con_pue")->first();
            $puesto = Puestos::where('con_pue', $idPuesto)->get();
            $candidato = Personas::where('con_persona', $value["con_persona"])->get();

            $nombre = $candidato->pluck("nombres")->first() . " " . $candidato->pluck("apellido1")->first() . " " . $candidato->pluck("apellido2")->first();

            $candidatos_item = array(
                "con_emp" => $empresas->pluck("descripcion")->first() ? $empresas->pluck("descripcion")->first() : "No hay dato",
                "candidato" => $nombre ? $nombre : "No hay dato",
                "puesto" => $puesto->pluck("descripcion")->first() ? $puesto->pluck("descripcion")->first() : "No hay dato",
                "fecha_creacion" => $value["created_at"] ? $value["created_at"] : "No hay dato",
                "acciones" => '<a style="font-size: 16px;color:green;" title="Descargar" href="#" onclick="informe('. $value['num_pruper'] .')" class="detalle-' . $value['num_pruper'] . '"><i class="fa fa-download" aria-hidden="true"></i></a> | <a style="font-size: 16px;color:green;" title="Descargar" href="#" onclick="pdf('. $value['num_pruper'] .')" class="detalle-' . $value['num_pruper'] . '"><i class="fa fa-download" aria-hidden="true"></i></a> | <a style="font-size: 16px;color:green;" title="Ver en linea" href="#" onclick="ver(this)" class="ver-' . $value['num_pruper'] . '"><i class="fa fa-chrome" aria-hidden="true"></i></a>');

            array_push($candidatos_arr, $candidatos_item);

        }

        return view('admin.candidatospruebas', 
          ['candidatos' => $candidatos_arr,           
          'nombre' => '', 
          'empresa' => '',
          '_user_' => $this->getUserData()]
        );
    }

    protected function getUserData() {
        if (!$user = Admin::user()) {
            return [];
        }

        return Arr::only($user->toArray(), ['id', 'username', 'email', 'name', 'avatar']);
    }
  function informe_resultado($id){

      $user = $this->getUserData();
      $TPersonasPruebas = PersonasPruebas::where('num_pruper', $id)->get();
      $con_emp = $TPersonasPruebas->pluck('con_emp')->first();
      $fecha = $TPersonasPruebas->pluck('fecha_prueba')->first();
      $numsec_prueba = $TPersonasPruebas->pluck('numsec_prueba')->first();
      $con_persona = $TPersonasPruebas->pluck('con_persona')->first();
      $TPersonas = Personas::where('con_persona', $con_persona)->get();
      $nombre = $TPersonas->pluck('nombres')->first() . " " . $TPersonas->pluck('apellido1')->first() . " " . $TPersonas->pluck('apellido2')->first();
      $Tempresas_pruebas = EmpresaPruebas::where('numsec_prueba', $numsec_prueba)->get();
      $con_pue = $Tempresas_pruebas->pluck("con_pue")->first();
      $Tpuestos = Puestos::where('con_pue',$con_pue);
      $puesto = $Tpuestos->pluck('descripcion')->first();
      $TEmpresas = Empresas::where('con_emp', $con_emp)->get();
      $empresa = $TEmpresas->pluck("descripcion")->first();    
      $fechagen = date("d-m-Y");
      
      return Redirect::to('candidatospruebas/informe_resultado')
             ->with(['num_pruper' => $id, 
                     'puesto' => $puesto, 
                     'empresa' => $empresa, 
                     'fecha' => $fecha, 
                     'nombre' => $nombre, 
                     '_user_' => $user]);    
  }

public function download($id)
{

      $user = $this->getUserData();
      $TPersonasPruebas = PersonasPruebas::where('num_pruper', $id)->get();
      $con_emp = $TPersonasPruebas->pluck('con_emp')->first();
      $fecha = $TPersonasPruebas->pluck('fecha_prueba')->first();
      $numsec_prueba = $TPersonasPruebas->pluck('numsec_prueba')->first();
      $con_persona = $TPersonasPruebas->pluck('con_persona')->first();
      $TPersonas = Personas::where('con_persona', $con_persona)->get();
      $nombre = $TPersonas->pluck('nombres')->first() . " " . $TPersonas->pluck('apellido1')->first() . " " . $TPersonas->pluck('apellido2')->first();
      $Tempresas_pruebas = EmpresaPruebas::where('numsec_prueba', $numsec_prueba)->get();
      $con_pue = $Tempresas_pruebas->pluck("con_pue")->first();
      $Tpuestos = Puestos::where('con_pue',$con_pue);
      $puesto = $Tpuestos->pluck('descripcion')->first();
      $TEmpresas = Empresas::where('con_emp', $con_emp)->get();
      $empresa = $TEmpresas->pluck("descripcion")->first();    
      $fechagen = date("d-m-Y");
      $data=['num_pruper' => $id, 
                     'puesto' => $puesto, 
                     'empresa' => $empresa, 
                     'fecha' => $fecha, 
                     'nombre' => $nombre, 
                     '_user_' => $user];
     $pdf = PDF::loadView('admin.informeresultado', compact('data'))->output();

         //$pdf = PDF::loadView('pdf.view')->output();

         // using Laravel helper function
      return response($pdf, 200,
        [
          'Content-Type'   => 'application/pdf',
          'Content-Length' =>  strlen($pdf),
          'Cache-Control'  => 'private, max-age=0, must-revalidate',
          'Pragma'         => 'public'
        ]
      );   
// dd($data);
     $content = PDF::loadView('admin.informeresultado', compact('data'))->output();
//dd($content)     ;
     //return $content;
     return $pdf->download('archivo.pdf');
     //return $pdf;
}  
    public function informe($id) {

      $TPersonasPruebas = PersonasPruebas::where('num_pruper', $id)->get();
      $con_emp = $TPersonasPruebas->pluck('con_emp')->first();
      $fecha = $TPersonasPruebas->pluck('fecha_prueba')->first();
      $numsec_prueba = $TPersonasPruebas->pluck('numsec_prueba')->first();
      $con_persona = $TPersonasPruebas->pluck('con_persona')->first();
      $TPersonas = Personas::where('con_persona', $con_persona)->get();
      $nombre = $TPersonas->pluck('nombres')->first() . " " . $TPersonas->pluck('apellido1')->first() . " " . $TPersonas->pluck('apellido2')->first();
      $Tempresas_pruebas = EmpresaPruebas::where('numsec_prueba', $numsec_prueba)->get();
      $con_pue = $Tempresas_pruebas->pluck("con_pue")->first();
      $Tpuestos = Puestos::where('con_pue',$con_pue);
      $puesto = $Tpuestos->pluck('descripcion')->first();
      $TEmpresas = Empresas::where('con_emp', $con_emp)->get();
      $empresa = $TEmpresas->pluck("descripcion")->first();    
      $fechagen = date("d-m-Y");

      $Tpersonaspruebasresultado = PersonasPruebasResultado::where('num_pruper', $id)->get();

      if(!count($Tpersonaspruebasresultado)){
var_dump("ENTRO");
        $TPersonasPruebasDetalle = 
          PersonasPruebasDetalle::select('persona_pruebas_detalle.*','competencias.con_tipo')
          ->join('competencias','competencias.con_comp','=','persona_pruebas_detalle.con_comp')
          ->where('persona_pruebas_detalle.num_pruper', $id)
          ->orderby('competencias.con_tipo')
          ->orderby('persona_pruebas_detalle.con_comp')
          ->orderby('persona_pruebas_detalle.con_preg')
          ->orderby('persona_pruebas_detalle.con_opci')
          ->get();
        $inicio = 0;
        $con_comp_ant = 0;
        $con_tipo_ant = 0;
        $tot_preg = 0;
        $valor_esperado = 0;
        $tot_tipo = 0;
        $izqder = 0;
        $izq = 0;
        $der = 0;              
        $totizq = 0;
        $totder = 0;
        $val_opciacu = 0;
        $con_test = 0;
        $tipo_calificacion_ant = "";
        $totcom_pun = 0;
        $totcom_punlog = 0;
        $tipo_calificacion = "";
        $finpuntaje=0;

        foreach ($TPersonasPruebasDetalle as $key => $value) {
          if($inicio==0){
            $con_emp = $value['con_emp'];
            $con_persona = $value['con_persona'];
            $numsec_prueba = $value['numsec_prueba'];
            $num_pruper = $value['num_pruper'];
            $Tempresas_pruebas = EmpresaPruebas::where('numsec_prueba', $numsec_prueba)->get();
            $con_pue = $Tempresas_pruebas->pluck("con_pue")->first();
            $Tpuestos = Puestos::where('con_pue',$con_pue);
            $puesto = $Tpuestos->pluck('descripcion')->first();
          }
          $con_comp = $value['con_comp'];
          $con_tipo = $value['con_tipo'];
          $Tcompetencias_tipos = CompetenciasTipos::where('con_tipo', $con_tipo)->get();
          $tipo_calificacion = $Tcompetencias_tipos->pluck('tipo_calificacion')->first();
          if($con_comp != $con_comp_ant){
            if($con_comp_ant>0){
              var_dump("Cambio competencia " . $con_comp . " " . $con_comp_ant . " izqder= " . $izqder . " izq= " . $izq . " der= " .$der . " valor_esperado= " . $valor_esperado . " TC: " . $tipo_calificacion_ant);
              if($izqder==0){
                $con_puntaje = 0;
                if($tipo_calificacion_ant == "Puntaje"){
                  if($tipo_calificacion!="Puntaje"){
                    $finpuntaje = 1;
                  }

                  $valor_promedio = $val_opciacu / $tot_preg;
                  if($valor_promedio < $valor_esperado){
                    $Tcalificacion_resultados = CalificacionResultados::where(
                      ['con_tipo' => $con_tipo_ant, 
                      'con_comp' => $con_comp_ant, 
                      'tipo_puntuacion' => 'PC'])
                      ->where('rango_inicial' , '>=' , $valor_esperado )
                      ->where('rango_final' , '<=', $valor_esperado)->get();
                    if(count($Tcalificacion_resultados)){
                      $con_puntaje = $Tcalificacion_resultados->pluck("con_puntaje")->first();
                      var_dump("AA Competencia SI encontró puntaje PC " . $valor_esperado);

                    }
                    else{
                      var_dump("A Competencia No encontró puntaje PC " . $valor_esperado);
                    }                          
                  }
                  else{
                    $totcom_punlog++;
                  }
                     
                } //$tipo_calificacion_ant == "Puntaje"
                if($tipo_calificacion_ant == "Frecuencia"){
                  $Tcalificacion_resultados = CalificacionResultados::where(['con_tipo' => $con_tipo_ant, 'con_comp' => $con_comp_ant, 'tipo_puntuacion' => 'PC'])
                  ->where('rango_inicial' , '<=' , $val_opciacu )
                  ->where('rango_final' , '>=', $val_opciacu)->get();
                  if(count($Tcalificacion_resultados)){
                    $con_puntaje = $Tcalificacion_resultados->pluck("con_puntaje")->first();
                  }
                  else{
                    var_dump("B Competencia No encontró puntaje PC " . $val_opciacu);
                  }                          
                }
                $valor_promedio = $val_opciacu / $tot_preg;
                $ppr = PersonasPruebasResultado::create([
                       'con_emp' => $con_emp,
                       'con_persona' => $con_persona,
                       'numsec_prueba' => $numsec_prueba,
                       'num_pruper' => $num_pruper,
                       'con_test' => $con_test_ant,
                       'con_tipo' => $con_tipo_ant,
                       'con_comp' => $con_comp_ant,
                       'con_puntaje' => $con_puntaje,
                       'puntaje_obtenido' => $val_opciacu,
                       'puntaje_esperado' => $valor_esperado,
                       'puntaje_promedio' => $valor_promedio ,
                      ]);
              } //$izqder==0
              else{
                $Tcalificacion_resultados = CalificacionResultados::where(['con_tipo' => $con_tipo_ant, 'con_comp' => $con_comp_ant, 'tipo_puntuacion' => 'PC'])
                ->where('rango_inicial' , '=' , $izq )
                ->where('rango_final' , '=', $der)->get();
                if(count($Tcalificacion_resultados)){
                  $con_puntaje = $Tcalificacion_resultados->pluck("con_puntaje")->first();
                }
                else{
                  var_dump("C Competencia No encontró puntaje PC " . $izq . " " . $der);
                }
                $ppr = PersonasPruebasResultado::create([
                       'con_emp' => $con_emp,
                       'con_persona' => $con_persona,
                       'numsec_prueba' => $numsec_prueba,
                       'num_pruper' => $num_pruper,
                       'con_test' => $con_test_ant,
                       'con_tipo' => $con_tipo_ant,
                       'con_comp' => $con_comp_ant,
                       'puntaje_obtenido' => 0,
                       'puntaje_esperado' => 0,
                       'puntaje_promedio' => 0,
                       'balizq' => $izq,
                       'balder' => $der,
                       'puntaje_promedio' => 0,
                       'con_puntaje' => $con_puntaje,
                      ]);
              } //else izq
                         
            } //$con_comp_ant>0
            $izq = 0;
            $der = 0;
            $tot_preg = 0;
            $valor_esperado = 0;
            $val_opciacu = 0;
            $izqder = 0;
            var_dump("Guardando totcom_pun_ant" . $con_comp . " cca " . $con_comp_ant . " tcp " . $totcom_pun);
            $totcom_pun_ant = $totcom_pun;
            $totcom_pun = 0;
            $totcom_punlog_ant = $totcom_punlog;
            $totcom_punlog = 0;
            $con_comp_ant = $con_comp;
            $Tcompetencias = Competencias::where('con_comp',$con_comp);
            $con_tipo = $Tcompetencias->pluck("con_tipo")->first();
            $Tcompetencias_tipos = CompetenciasTipos::where('con_tipo', $con_tipo)->get();
            $tipo_calificacion_ant = $tipo_calificacion;
            $tipo_calificacion = $Tcompetencias_tipos->pluck('tipo_calificacion')->first();

            if($tipo_calificacion_ant==""){
              $tipo_calificacion_ant = $tipo_calificacion;
            }
            if($tipo_calificacion=="Puntaje"){
              var_dump("Puntaje");
              $Tempresaspuestoscompetencias = EmpresasPuestosCompetencias::where(['con_emp' => $con_emp, 'con_pue' => $con_pue, 'con_comp' => $con_comp])->get();
              if(count($Tempresaspuestoscompetencias)){
                var_dump("Encontró Puntaje");
                $con_nivdom = $Tempresaspuestoscompetencias->pluck("con_nivdom")->first();
                $Tempresas_competencias_niveldominio = EmpresasCompetenciasNiveldominio::where(['con_emp' => $con_emp,'con_nivdom' => $con_nivdom]);
                $valor_esperado = $Tempresas_competencias_niveldominio->pluck("valor_esperado")->first();
                var_dump("Valor esperado " . $valor_esperado);
              }
            }
            if($tipo_calificacion=="Balance"){
              $izqder = 1;
              var_dump("Tipo balance " . $con_comp);
            }
          } //if($con_comp_ant>0){

          if($con_tipo  != $con_tipo_ant){
                  
            if($con_tipo_ant>0){
              var_dump("Cambio tipo " . $con_tipo . " " . $con_tipo_ant . " NL " . $totcom_punlog);
                    //Guardar total por tipo
              if($izqder==0){
                $con_puntaje = 0;
                if($finpuntaje>0){
                  $Tcalificacion_resultados = 
                  CalificacionResultados::where(['con_tipo' => $con_tipo_ant, 'tipo_puntuacion' => 'PNEL'])
                  ->where('rango_inicial' , '<=' , $totcom_punlog )
                  ->where('rango_final' , '>=', $totcom_punlog)->get();
                  if(count($Tcalificacion_resultados)){
                    $con_puntaje = $Tcalificacion_resultados->pluck("con_puntaje")->first();
                    var_dump("Tipo SI encontró puntaje PNEL " . $totcom_punlog . " tcpa: " . $totcom_pun_ant . " tcp: " . $totcom_pun);                      
                  }
                  else{
                    var_dump("Tipo No encontró puntaje PNEL " . $totcom_punlog . " tcpa: " . $totcom_pun_ant . " tcp: " . $totcom_pun);
                  }
                  $finpuntaje=0;
                }
                else{
                  if($tot_tipo>0){
                    $Tcalificacion_resultados = 
                    CalificacionResultados::where(['con_tipo' => $con_tipo_ant, 'tipo_puntuacion' => 'PTC'])
                    ->where('rango_inicial' , '<=' , $tot_tipo )
                    ->where('rango_final' , '>=', $tot_tipo)->get();
                    if(count($Tcalificacion_resultados)){
                      $con_puntaje = $Tcalificacion_resultados->pluck("con_puntaje")->first();
                    }
                    else{
                      var_dump("Tipo No encontró puntaje PTC " . $tot_tipo);
                    }
                  }                        
                }

                $ppr = PersonasPruebasResultado::create([
                       'con_emp' => $con_emp,
                       'con_persona' => $con_persona,
                       'numsec_prueba' => $numsec_prueba,
                       'num_pruper' => $num_pruper,
                       'con_test' => $con_test_ant,
                       'con_tipo' => $con_tipo_ant,
                       'con_comp' => 0,
                       'puntaje_obtenido' => $tot_tipo,
                       'puntaje_esperado' => 0,
                       'puntaje_promedio' => 0,
                       'con_puntaje' => $con_puntaje,
                      ]);
              } //$izqder==0
              else{
                $ppr = PersonasPruebasResultado::create([
                       'con_emp' => $con_emp,
                       'con_persona' => $con_persona,
                       'numsec_prueba' => $numsec_prueba,
                       'num_pruper' => $num_pruper,
                       'con_test' => $con_test_ant,
                       'con_tipo' => $con_tipo_ant,
                       'con_comp' => 0,
                       'puntaje_obtenido' => 0,
                       'puntaje_esperado' => 0,
                       'puntaje_promedio' => 0,
                       'balizq' => $totizq,
                       'balder' => $totder,
                      ]);
              }       
          
            } //$con_tipo_ant>0
            $con_tipo_ant = $con_tipo;
            $tot_tipo = 0;
            $totizq = 0;
            $totder = 0;

          } //$con_tipo  != $con_tipo_ant

          $con_comp_ant = $con_comp;
                
          $con_test_ant = $con_test;
          $con_test = $value['con_test'];
          $con_preg = $value['con_preg'];
          $con_opci = $value['con_opci'];
            
var_dump($con_tipo . " " . $con_comp . " " . $con_preg . " " . $con_opci);
          $Tcompetenciaspreguntasopciones = PreguntasOpciones::where(['con_comp' => $con_comp, 'con_preg' => $con_preg, 'con_opci' => $con_opci])->get();
          $val_asiopci = $Tcompetenciaspreguntasopciones->pluck("val_asiopci")->first();                    
          if($izqder==1){
            if($val_asiopci==0){
              $izq++;
            }
            else{
              $der++;
            }
          }

          $val_opciacu = $val_opciacu + $val_asiopci;
          $tot_tipo = $tot_tipo + $val_asiopci;
          $tot_preg++;

        } //foreach
        var_dump("Final " . $con_comp . " " . $con_comp_ant);
        if(1==1){
          if($con_comp_ant>0){
            var_dump("Cambio competencia " . $con_comp . " " . $con_comp_ant . " izqder= " . $izqder . " izq= " . $izq . " der= " .$der . " valor_esperado= " . $valor_esperado . " TC: " . $tipo_calificacion_ant);
            if($izqder==0){
              $con_puntaje = 0;
              if($tipo_calificacion_ant == "Puntaje"){
                if($tipo_calificacion!="Puntaje"){
                  $finpuntaje = 1;
                }

                $valor_promedio = $val_opciacu / $tot_preg;
                if($valor_promedio < $valor_esperado){
                  $Tcalificacion_resultados = CalificacionResultados::where(
                      ['con_tipo' => $con_tipo_ant, 
                      'con_comp' => $con_comp_ant, 
                      'tipo_puntuacion' => 'PC'])
                  ->where('rango_inicial' , '>=' , $valor_esperado )
                  ->where('rango_final' , '<=', $valor_esperado)->get();
                  if(count($Tcalificacion_resultados)){
                    $con_puntaje = $Tcalificacion_resultados->pluck("con_puntaje")->first();
                    var_dump("AA Competencia SI encontró puntaje PC " . $valor_esperado);
                  }
                  else{
                    var_dump("A Competencia No encontró puntaje PC " . $valor_esperado);
                  }                          
                }
                else{
                  $totcom_punlog++;
                }                     
              }
              if($tipo_calificacion_ant == "Frecuencia"){
                $Tcalificacion_resultados = CalificacionResultados::where(['con_tipo' => $con_tipo_ant, 'con_comp' => $con_comp_ant, 'tipo_puntuacion' => 'PC'])
                ->where('rango_inicial' , '<=' , $val_opciacu )
                ->where('rango_final' , '>=', $val_opciacu)->get();
                if(count($Tcalificacion_resultados)){
                  $con_puntaje = $Tcalificacion_resultados->pluck("con_puntaje")->first();
                }
                else{
                  var_dump("B Competencia No encontró puntaje PC " . $val_opciacu);
                }                          
              }
              $valor_promedio = $val_opciacu / $tot_preg;
              $ppr = PersonasPruebasResultado::create([
                       'con_emp' => $con_emp,
                       'con_persona' => $con_persona,
                       'numsec_prueba' => $numsec_prueba,
                       'num_pruper' => $num_pruper,
                       'con_test' => $con_test_ant,
                       'con_tipo' => $con_tipo_ant,
                       'con_comp' => $con_comp_ant,
                       'con_puntaje' => $con_puntaje,
                       'puntaje_obtenido' => $val_opciacu,
                       'puntaje_esperado' => $valor_esperado,
                       'puntaje_promedio' => $valor_promedio ,
                      ]);
            }
            else{
              $Tcalificacion_resultados = CalificacionResultados::where(['con_tipo' => $con_tipo_ant, 'con_comp' => $con_comp_ant, 'tipo_puntuacion' => 'PC'])
              ->where('rango_inicial' , '=' , $izq )
              ->where('rango_final' , '=', $der)->get();
              if(count($Tcalificacion_resultados)){
                $con_puntaje = $Tcalificacion_resultados->pluck("con_puntaje")->first();
              }
              else{
                var_dump("C Competencia No encontró puntaje PC " . $izq . " " . $der);
              }
              $ppr = PersonasPruebasResultado::create([
                       'con_emp' => $con_emp,
                       'con_persona' => $con_persona,
                       'numsec_prueba' => $numsec_prueba,
                       'num_pruper' => $num_pruper,
                       'con_test' => $con_test_ant,
                       'con_tipo' => $con_tipo_ant,
                       'con_comp' => $con_comp_ant,
                       'puntaje_obtenido' => 0,
                       'puntaje_esperado' => 0,
                       'puntaje_promedio' => 0,
                       'balizq' => $izq,
                       'balder' => $der,
                       'puntaje_promedio' => 0,
                       'con_puntaje' => $con_puntaje,
                      ]);
            }
                         
          }
          $izq = 0;
          $der = 0;
          $tot_preg = 0;
          $valor_esperado = 0;
          $val_opciacu = 0;
          $izqder = 0;
          var_dump("Guardando totcom_pun_ant" . $con_comp . " cca " . $con_comp_ant . " tcp " . $totcom_pun);
          $totcom_pun_ant = $totcom_pun;
          $totcom_pun = 0;
          $totcom_punlog_ant = $totcom_punlog;
          $totcom_punlog = 0;
          $con_comp_ant = $con_comp;
          $Tcompetencias = Competencias::where('con_comp',$con_comp);
          $con_tipo = $Tcompetencias->pluck("con_tipo")->first();
          $Tcompetencias_tipos = CompetenciasTipos::where('con_tipo', $con_tipo)->get();
          $tipo_calificacion_ant = $tipo_calificacion;
          $tipo_calificacion = $Tcompetencias_tipos->pluck('tipo_calificacion')->first();

          if($tipo_calificacion_ant==""){
            $tipo_calificacion_ant = $tipo_calificacion;
          }
          if($tipo_calificacion=="Puntaje"){
            var_dump("Puntaje");
            $Tempresaspuestoscompetencias = EmpresasPuestosCompetencias::where(['con_emp' => $con_emp, 'con_pue' => $con_pue, 'con_comp' => $con_comp])->get();
            if(count($Tempresaspuestoscompetencias)){
              var_dump("Encontró Puntaje");
              $con_nivdom = $Tempresaspuestoscompetencias->pluck("con_nivdom")->first();
              $Tempresas_competencias_niveldominio = EmpresasCompetenciasNiveldominio::where(['con_emp' => $con_emp,'con_nivdom' => $con_nivdom]);
              $valor_esperado = $Tempresas_competencias_niveldominio->pluck("valor_esperado")->first();
              var_dump("Valor esperado " . $valor_esperado);
            }
          }
          if($tipo_calificacion=="Balance"){
            $izqder = 1;
            var_dump("Tipo balance " . $con_comp);
          }
        } //if($con_comp_ant>0){

        if($con_tipo  != $con_tipo_ant){
                  
          if($con_tipo_ant>0){
            var_dump("Cambio tipo " . $con_tipo . " " . $con_tipo_ant . " NL " . $totcom_punlog);
                    //Guardar total por tipo
            if($izqder==0){
              $con_puntaje = 0;
              if($finpuntaje>0){
                $Tcalificacion_resultados = 
                  CalificacionResultados::where(['con_tipo' => $con_tipo_ant, 'tipo_puntuacion' => 'PNEL'])
                  ->where('rango_inicial' , '<=' , $totcom_punlog )
                  ->where('rango_final' , '>=', $totcom_punlog)->get();
                if(count($Tcalificacion_resultados)){
                  $con_puntaje = $Tcalificacion_resultados->pluck("con_puntaje")->first();
                  var_dump("Tipo SI encontró puntaje PNEL " . $totcom_punlog . " tcpa: " . $totcom_pun_ant . " tcp: " . $totcom_pun);                      
                }
                else{
                  var_dump("Tipo No encontró puntaje PNEL " . $totcom_punlog . " tcpa: " . $totcom_pun_ant . " tcp: " . $totcom_pun);
                }
                $finpuntaje=0;
              }
              else{
                if($tot_tipo>0){
                  $Tcalificacion_resultados = 
                    CalificacionResultados::where(['con_tipo' => $con_tipo_ant, 'tipo_puntuacion' => 'PTC'])
                    ->where('rango_inicial' , '<=' , $tot_tipo )
                    ->where('rango_final' , '>=', $tot_tipo)->get();
                  if(count($Tcalificacion_resultados)){
                    $con_puntaje = $Tcalificacion_resultados->pluck("con_puntaje")->first();
                  }
                  else{
                    var_dump("Tipo No encontró puntaje PTC " . $tot_tipo);
                  }
                }                        
              }

              $ppr = PersonasPruebasResultado::create([
                       'con_emp' => $con_emp,
                       'con_persona' => $con_persona,
                       'numsec_prueba' => $numsec_prueba,
                       'num_pruper' => $num_pruper,
                       'con_test' => $con_test_ant,
                       'con_tipo' => $con_tipo_ant,
                       'con_comp' => 0,
                       'puntaje_obtenido' => $tot_tipo,
                       'puntaje_esperado' => 0,
                       'puntaje_promedio' => 0,
                       'con_puntaje' => $con_puntaje,
                      ]);
            } 
            else{
              $ppr = PersonasPruebasResultado::create([
                       'con_emp' => $con_emp,
                       'con_persona' => $con_persona,
                       'numsec_prueba' => $numsec_prueba,
                       'num_pruper' => $num_pruper,
                       'con_test' => $con_test_ant,
                       'con_tipo' => $con_tipo_ant,
                       'con_comp' => 0,
                       'puntaje_obtenido' => 0,
                       'puntaje_esperado' => 0,
                       'puntaje_promedio' => 0,
                       'balizq' => $totizq,
                       'balder' => $totder,
                      ]);
            }       
          
          }
          $con_tipo_ant = $con_tipo;
          $tot_tipo = 0;
          $totizq = 0;
          $totder = 0;

        }

      } // primer if
//
      
      // return Redirect::route('candidatospruebas.informeresultado')
      //       ->with(['num_pruper' => $id, 
      //               'puesto' => $puesto, 
      //               'empresa' => $empresa, 
      //               'fecha' => $fecha, 
      //               'nombre' => $nombre, 
      //               '_user_' => $this->getUserData()]);
          
          $data = array(
            'num_pruper' => $id,
            'puesto' => $puesto, 
            'empresa' => $empresa, 
            'fecha' => $fecha, 
            'nombre' => $nombre, 
          );
        $testData['data'] = $data;
        return response()->json($testData);            

         // $view = view('admin.candidatospruebas', 
         //  ['num_pruper' => $id,
         //   'puesto' => $puesto, 
         //   'empresa' => $empresa, 
         //   'candidatos' => $candidatos_arr,
         //   'fecha' => $fecha, 
         //   'nombre' => $nombre, 
         //   '_user_' => $this->getUserData()]
         // )->render();
         // return $view;
//        
        
    }

}
