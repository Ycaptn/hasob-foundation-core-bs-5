<?php
namespace Hasob\FoundationCore\Managers;

use Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;

use Hasob\FoundationCore\Models\Organization;
use Hasob\FoundationCore\Models\ModelDocument;
use Hasob\FoundationCore\Models\DocumentGenerationTemplate;


class DocumentManager {

    public function __construct(){
    }

    public static function previewDocumentToPDF($template_id, $subject_model_id, $subject_model_type, $model_document_id){

        //Get the template
        $documentGenerationTemplate = DocumentGenerationTemplate::find($template_id);

        //Invoke the subject model
        $model = new $subject_model_type();
        if ($model != null){
            $subject = $model->find($subject_model_id);
        }

        //Render the template as PDF and return the stream
        $rendered_content = Blade::render($documentGenerationTemplate->content,['subject'=>$subject]);
        $html_content = \Illuminate\Mail\Markdown::parse($rendered_content);

        if ($model_document_id != null){
            $model_document = ModelDocument::find($model_document_id);
            if ($model_document !=null && $model_document->model_primary_id!=null){
                
                //Invoke the subject model
                $model_document_subject = $model_document->model_type_name::find($model_document->model_primary_id);
                if ($model_document_subject != null && $model_document->document_generation_template_id!=null){
                    $model_document_content_template = DocumentGenerationTemplate::find($model_document->document_generation_template_id);
                    if (empty($model_document_content_template->content) == false){
                        $model_document_content_rendered = Blade::render($model_document_content_template->content,['subject'=>$model_document_subject]);
                        $model_document_html_content = \Illuminate\Mail\Markdown::parse($model_document_content_rendered);
                        $html_content = \str_replace("<!-- CONTENT -->",$html_content,$model_document_html_content);
                    }
                }
            }
        }

        $pdf = new \Mpdf\Mpdf(["margin_top" => 8, "margin_bottom" => 8]);
        $pdf->WriteHTML($html_content);
        return $pdf->Output();

    }

    public static function saveDocument($template_id, $subject_model_id, $subject_model_type, $content_type, $file_name, $model_document_id){

        //Get the template
        $documentGenerationTemplate = DocumentGenerationTemplate::find($template_id);

        //Invoke the subject model
        $model = new $subject_model_type();
        if ($model != null){
            $subject = $model->find($subject_model_id);
        }

        //Render the template as PDF and return the stream
        $rendered_content = Blade::render($documentGenerationTemplate->content,['subject'=>$subject]);
        $html_content = \Illuminate\Mail\Markdown::parse($rendered_content);


        if ($model_document_id != null){
            $model_document = ModelDocument::find($model_document_id);
            if ($model_document !=null && $model_document->model_primary_id!=null){
                
                //Invoke the subject model
                $model_document_subject = $model_document->model_type_name::find($model_document->model_primary_id);
                if ($model_document_subject != null && $model_document->document_generation_template_id!=null){
                    $model_document_content_template = DocumentGenerationTemplate::find($model_document->document_generation_template_id);
                    if (empty($model_document_content_template->content) == false){
                        $model_document_content_rendered = Blade::render($model_document_content_template->content,['subject'=>$model_document_subject]);
                        $model_document_html_content = \Illuminate\Mail\Markdown::parse($model_document_content_rendered);
                        $html_content = \str_replace("<!-- CONTENT -->",$html_content,$model_document_html_content);
                    }
                }
            }
        }

        $generated_file_path = self::saveAsMsWord($html_content, $file_name);

        //Attach the file to the model as a document
        if ($subject != null && !empty($generated_file_path)){
            $subject->save_file(Auth::user(), $file_name, "", $generated_file_path);
        }

        return $generated_file_path;
    }

    private static function saveAsMsWord($content, $file_name){

        $full_file_path = null;
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->addParagraphStyle('Heading2', ['alignment' => 'center']);

        try {
            $section = $phpWord->addSection();
            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $content, false, false);

            $full_file_path = storage_path("{$file_name}.docx");

            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save($full_file_path);

        } catch (\Exception $e) {
            Log::error("Unable to write word document {$full_file_path}");
            Log::error($e->getMessage());
        }

        return $full_file_path;
    }

}
