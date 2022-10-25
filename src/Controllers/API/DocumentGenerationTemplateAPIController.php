<?php

namespace Hasob\FoundationCore\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hasob\FoundationCore\Models\DocumentGenerationTemplate;

use Hasob\FoundationCore\Events\DocumentGenerationTemplateCreated;
use Hasob\FoundationCore\Events\DocumentGenerationTemplateUpdated;
use Hasob\FoundationCore\Events\DocumentGenerationTemplateDeleted;

use Hasob\FoundationCore\Requests\API\CreateDocumentGenerationTemplateAPIRequest;
use Hasob\FoundationCore\Requests\API\UpdateDocumentGenerationTemplateAPIRequest;

use Hasob\FoundationCore\Traits\ApiResponder;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;

use Illuminate\Support\Facades\Log;

/**
 * Class DocumentGenerationTemplateController
 * @package Hasob\FoundationCore\Controllers\API
 */

class DocumentGenerationTemplateAPIController extends AppBaseController
{

    use ApiResponder;

    /**
     * Display a listing of the DocumentGenerationTemplate.
     * GET|HEAD /documentGenerationTemplates
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = DocumentGenerationTemplate::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        
        if ($organization != null){
            $query->where('organization_id', $organization->id);
        }

        $documentGenerationTemplates = $this->showAll($query->get());

        return $this->sendResponse($documentGenerationTemplates->toArray(), 'Document Generation Templates retrieved successfully');
    }

    /**
     * Store a newly created DocumentGenerationTemplate in storage.
     * POST /documentGenerationTemplates
     *
     * @param CreateDocumentGenerationTemplateAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateDocumentGenerationTemplateAPIRequest $request, Organization $organization)
    {

        $input = $request->all();
        $documentGenerationTemplate = DocumentGenerationTemplate::create($input);
        $documentGenerationTemplate->output_content_types = $request->output_types;
        $documentGenerationTemplate->save();

        $this->update_model_documents($documentGenerationTemplate, $request->doc_models);

        DocumentGenerationTemplateCreated::dispatch($documentGenerationTemplate);
        return $this->sendResponse($documentGenerationTemplate->toArray(), 'Document Generation Template saved successfully');
    }

    /**
     * Display the specified DocumentGenerationTemplate.
     * GET|HEAD /documentGenerationTemplates/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        $documentGenerationTemplate = DocumentGenerationTemplate::find($id);

        if (empty($documentGenerationTemplate)) {
            return $this->sendError('Document Generation Template not found');
        }

        $model_names = \Hasob\FoundationCore\Models\ModelDocument::where('document_generation_template_id',$documentGenerationTemplate->id)
                                                        ->where('is_default_template', 1)
                                                        ->pluck('model_type_name')
                                                        ->all();
        
        $documentGenerationTemplate->model_names = implode(",", $model_names);

        return $this->sendResponse($documentGenerationTemplate->toArray(), 'Document Generation Template retrieved successfully');
    }

    /**
     * Update the specified DocumentGenerationTemplate in storage.
     * PUT/PATCH /documentGenerationTemplates/{id}
     *
     * @param int $id
     * @param UpdateDocumentGenerationTemplateAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDocumentGenerationTemplateAPIRequest $request, Organization $organization)
    {
        $documentGenerationTemplate = DocumentGenerationTemplate::find($id);

        if (empty($documentGenerationTemplate)) {
            return $this->sendError('Document Generation Template not found');
        }

        $documentGenerationTemplate->fill($request->all());
        $documentGenerationTemplate->output_content_types = $request->output_types;
        $documentGenerationTemplate->save();

        $this->update_model_documents($documentGenerationTemplate, $request->doc_models);
        
        DocumentGenerationTemplateUpdated::dispatch($documentGenerationTemplate);
        return $this->sendResponse($documentGenerationTemplate->toArray(), 'DocumentGenerationTemplate updated successfully');
    }

    private function update_model_documents($documentGenerationTemplate, $models_str){

        if ($documentGenerationTemplate!=null && $documentGenerationTemplate->id!=null){

            \Hasob\FoundationCore\Models\ModelDocument::where('document_generation_template_id',$documentGenerationTemplate->id)
                                                        ->where('is_default_template', 1)
                                                        ->delete();

            $model_type_names = explode(",", $models_str);

            foreach($model_type_names as $idx=>$type_name){
                $model_doc = \Hasob\FoundationCore\Models\ModelDocument::create([
                    'organization_id'=>$documentGenerationTemplate->organization_id,
                    'document_generation_template_id'=>$documentGenerationTemplate->id,
                    'model_type_name'=> $type_name,
                    'is_default_template'=>1,
                ]);
            }
        }

    }

    /**
     * Remove the specified DocumentGenerationTemplate from storage.
     * DELETE /documentGenerationTemplates/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Organization $organization)
    {
        /** @var DocumentGenerationTemplate $documentGenerationTemplate */
        $documentGenerationTemplate = DocumentGenerationTemplate::find($id);

        if (empty($documentGenerationTemplate)) {
            return $this->sendError('Document Generation Template not found');
        }

        $documentGenerationTemplate->delete();
        DocumentGenerationTemplateDeleted::dispatch($documentGenerationTemplate);
        return $this->sendSuccess('Document Generation Template deleted successfully');
    }
}
