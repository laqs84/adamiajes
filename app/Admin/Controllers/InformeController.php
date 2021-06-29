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

class InformeController extends Controller {

    public function index() {
        
        $request = Admin::user();

        if($request["con_emp"] !==0){
         
         $empresas = Empresas::where('con_emp', $request["con_emp"])->get();
         $candidatos = PersonasPruebasDetalle::where('con_emp', $request["con_emp"])->get(); 
        }else{
            
        
        $candidatos = PersonasPruebasDetalle::all();
        
        $empresas = Empresas::all();
        }
        $candidatos_arr = array();
        foreach ($candidatos as $key => $value) {
            $empresas = Empresas::where('con_emp', $value['con_emp'])->get();
            $empresapruebas = EmpresaPruebas::where('numsec_prueba', $value['numsec_prueba'])->get();
            $idPuesto = $empresapruebas->pluck("con_pue")->first();
            $puesto = Puestos::where('con_pue', $idPuesto)->get();
            $candidato = Personas::where('con_persona', $value["con_persona"])->get(); 
            $competencia = Competencias::where('con_comp', $value['con_comp'])->get();
            $candidatos_item = array(
            "con_emp" => $empresas->pluck("descripcion")->first() ? $empresas->pluck("descripcion")->first() : "No hay dato",
            "candidato" => $candidato->pluck("nombres")->first()." ".$candidato->pluck("apellido1")->first()." ".$candidato->pluck("apellido2")->first() ? $candidato->pluck("nombres")->first()." ".$candidato->pluck("apellido1")->first()." ".$candidato->pluck("apellido2")->first() : "No hay dato",
            "puesto" => $puesto->pluck("descripcion")->first() ? $puesto->pluck("descripcion")->first() : "No hay dato",
            "competencia" => $competencia->pluck("descripcion")->first() ? $competencia->pluck("descripcion")->first() : "No hay dato",
            "acciones" => '<a style="font-size: 16px;color:green;" title="Descargar" href="#" onclick="detalle(this)" class="detalle-' . $value['con_prue_det'] . '"><i class="fa fa-download" aria-hidden="true"></i></a> | ');
        array_push($candidatos_arr, $candidatos_item);
        }
        
        return view('admin.candidatospruebas' , ['candidatos' => $candidatos_arr, '_user_'      => $this->getUserData()]);
   }


   
   protected function getUserData()
    {
        if (!$user = Admin::user()) {
            return [];
        }

        return Arr::only($user->toArray(), ['id', 'username', 'email', 'name', 'avatar']);
    }

    public function informe(Request $request) {
        try {
            $id = $request["id"];
            
            $prueba = PersonasPruebasDetalle::where('con_prue_det', $id)->get(); 
            $idEmpresa = $prueba->pluck("con_emp")->first();
            $idPersona = $prueba->pluck("con_persona")->first();
            $idTest = $prueba->pluck("con_test")->first();
            $idComp= $prueba->pluck("con_comp")->first();
            $idPreg = $prueba->pluck("con_preg")->first();
            $idOpci = $prueba->pluck("con_opci")->first();
            $numsec_prueba = $prueba->pluck("numsec_prueba")->first();
            
            $empresas = Empresas::where('con_emp', $idEmpresa)->get();
            $empresapruebas = EmpresaPruebas::where('numsec_prueba', $numsec_prueba)->get();
            
            $idPuesto = $empresapruebas->pluck("con_pue")->first();
            $puesto = Puestos::where('con_pue', $idPuesto)->get();
            
            
            $candidato = Personas::where('con_persona', $idPersona)->get(); 
            
            $competencia = Competencias::where('con_comp', $idComp)->get();
            
            $califi = CalificacionResultados::where('con_comp', $idComp)->get();
            
            $preguntas = Preguntas::where('con_comp', $idComp)->get();
            
            $preguntasOpciones = PreguntasOpciones::where('con_comp', $idComp)->get();
            
            
            /* Set the PDF Engine Renderer Path */
            $domPdfPath = base_path('vendor/dompdf/dompdf');
            \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
            \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

            /* @ Reading doc file */
            $template = new\PhpOffice\PhpWord\TemplateProcessor(resource_path('INFORME.docx'));

            /* @ Replacing variables in doc file */
            $template->setValue('nombrecompleto', 'Andres');

            /* @ Save Temporary Word File With New Name */
            $saveDocPath = tempnam(sys_get_temp_dir(), 'PHPWord');
            $template->saveAs($saveDocPath);

            // Load temporarily create word file
            $Content = \PhpOffice\PhpWord\IOFactory::load($saveDocPath);

            //Save it into PDF
            $savePdfPath = public_path('new-result.pdf');

            /* @ If already PDF exists then delete it */
            if (file_exists($savePdfPath)) {
                unlink($savePdfPath);
            }

            //Save it into PDF
            $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content, 'PDF');
            $PDFWriter->save($savePdfPath);

            /* @ Remove temporarily created word file */
            if (file_exists($saveDocPath)) {
                unlink($saveDocPath);
            }
            $header = [
                "Content-Type: application/octet-stream",
            ];
            return response()->download($savePdfPath, 'Informe.pdf', $header)->deleteFileAfterSend($shouldDelete = true);
        } catch (\PhpOffice\PhpWord\Exception\Exception $e) {
            //throw $th;
            return back($e->getCode());
        }
    }

}
