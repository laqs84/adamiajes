<?php
namespace App\Admin\Controllers;


Use App\Models\Competencias;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Arr;
Use App\Models\CompetenciasTipos;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Redirect;
use Exception;

class InformeController extends Controller
{
        public function index()
    {
       try {
            //code...
            /* Set the PDF Engine Renderer Path */
        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
         
        /*@ Reading doc file */
        $template = new\PhpOffice\PhpWord\TemplateProcessor(resource_path('INFORME.docx'));
 
        /*@ Replacing variables in doc file */
        $template->setValue('nombrecompleto', 'Andres');
 
        /*@ Save Temporary Word File With New Name */
        $saveDocPath = tempnam(sys_get_temp_dir(),'PHPWord');
        $template->saveAs($saveDocPath);
         
        // Load temporarily create word file
        $Content = \PhpOffice\PhpWord\IOFactory::load($saveDocPath); 
 
        //Save it into PDF
        $savePdfPath = public_path('new-result.pdf');
 
        /*@ If already PDF exists then delete it */
        if ( file_exists($savePdfPath) ) {
            unlink($savePdfPath);
        }
 
        //Save it into PDF
        $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content,'PDF');
        $PDFWriter->save($savePdfPath); 
       
 
        /*@ Remove temporarily created word file */
        if ( file_exists($saveDocPath) ) {
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