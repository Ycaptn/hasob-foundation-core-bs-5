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

    public static function previewDocumentToPDF($template_id, $subject_model_id, $subject_model_type){

        //Get the template
        $documentGenerationTemplate = DocumentGenerationTemplate::find($template_id);

        //Invoke the subject model
        $model = new $subject_model_type();
        if ($model != null){
            $subject = $model->find($subject_model_id);
        }

        //Render the template as PDF and return the stream
        // $html_content = Str::markdown($documentGenerationTemplate->content);
        $rendered_content = Blade::render($documentGenerationTemplate->content,['subject'=>$subject]);
        $html_content = \Illuminate\Mail\Markdown::parse($rendered_content);
        //$rendered_content = Blade::render($html_content,['subject'=>$subject]);

        // $markdown = new \Illuminate\Mail\Markdown();
        // $content = \Illuminate\Mail\Markdown::render($documentGenerationTemplate->content,['subject'=>$subject]);

        $pdf = new \Mpdf\Mpdf(["margin_top" => 8, "margin_bottom" => 8]);
        $pdf->WriteHTML($html_content);
        return $pdf->Output();

    }

}
