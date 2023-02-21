<?php

namespace Hasob\FoundationCore\Controllers;

use Hasob\FoundationCore\Models\DocumentGenerationTemplate;

use Hasob\FoundationCore\Events\DocumentGenerationTemplateCreated;
use Hasob\FoundationCore\Events\DocumentGenerationTemplateUpdated;
use Hasob\FoundationCore\Events\DocumentGenerationTemplateDeleted;

use Hasob\FoundationCore\Requests\CreateDocumentGenerationTemplateRequest;
use Hasob\FoundationCore\Requests\UpdateDocumentGenerationTemplateRequest;

use Hasob\FoundationCore\DataTables\DocumentGenerationTemplateDataTable;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;

use Flash;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class DocumentGeneratorController extends BaseController
{

    public function processPDFPreview(Organization $org, Request $request, $template_id) {

        $subject_model_id = $request->get('mid');
        $subject_model_type = $request->get('mpe');
        $model_document_id = $request->get('mdtid');

        $response = \Hasob\FoundationCore\Managers\DocumentManager::previewDocumentToPDF(
            $template_id, 
            $subject_model_id, 
            $subject_model_type,
            $model_document_id
        );

        ob_end_clean();
        return $response;
    }

    public function processFileSave(Organization $org, Request $request, $template_id) {

        $file_name = $request->fileName;
        $content_type = $request->contentType;
        $subject_model_id = $request->modelId;
        $subject_model_type = $request->modelType;
        $model_document_id = $request->modelDocumentId;
        $subjectName = ($request->subjectName != null) ? $request->subjectName : "subject";
        $otherParameter = $request->otherParameter;
        
        $response = \Hasob\FoundationCore\Managers\DocumentManager::saveDocument(
            $template_id, 
            $subject_model_id, 
            $subject_model_type,
            $content_type, 
            $file_name,
            $model_document_id,
            $otherParameter,
            $subjectName           
        );

        if (empty($response)) {
            return $this->sendError('Error generating this document. Please check the template being used.', 200);
        }

        return $this->sendResponse($response, 'File generated and attached. Please check the documents tab.');

    }

}
