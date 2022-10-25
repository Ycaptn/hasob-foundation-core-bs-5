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


class DocumentGenerationTemplateController extends BaseController
{
    /**
     * Display a listing of the DocumentGenerationTemplate.
     *
     * @param DocumentGenerationTemplateDataTable $documentGenerationTemplateDataTable
     * @return Response
     */
    public function index(Organization $org, DocumentGenerationTemplateDataTable $documentGenerationTemplateDataTable)
    {
        $current_user = Auth()->user();

        $cdv_document_generation_templates = new \Hasob\FoundationCore\View\Components\CardDataView(DocumentGenerationTemplate::class, "hasob-foundation-core::document_generation_templates.card_view_item");
        $cdv_document_generation_templates->setDataQuery(['organization_id'=>$org->id])
                        ->setSearchFields(['title'])
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(20)
                        ->setSearchPlaceholder('Search Templates');

        if (request()->expectsJson()){
            return $cdv_document_generation_templates->render();
        }

        return view('hasob-foundation-core::document_generation_templates.card_view_index')
                    ->with('current_user', $current_user)
                    ->with('months_list', BaseController::monthsList())
                    ->with('states_list', BaseController::statesList())
                    ->with('cdv_document_generation_templates', $cdv_document_generation_templates);
    }

    /**
     * Show the form for creating a new DocumentGenerationTemplate.
     *
     * @return Response
     */
    public function create(Organization $org)
    {
        return view('hasob-foundation-core::pages.document_generation_templates.create');
    }

    /**
     * Store a newly created DocumentGenerationTemplate in storage.
     *
     * @param CreateDocumentGenerationTemplateRequest $request
     *
     * @return Response
     */
    public function store(Organization $org, CreateDocumentGenerationTemplateRequest $request)
    {
        $input = $request->all();

        /** @var DocumentGenerationTemplate $documentGenerationTemplate */
        $documentGenerationTemplate = DocumentGenerationTemplate::create($input);

        //Flash::success('Document Generation Template saved successfully.');

        DocumentGenerationTemplateCreated::dispatch($documentGenerationTemplate);
        return redirect(route('fc.documentGenerationTemplates.index'));
    }

    /**
     * Display the specified DocumentGenerationTemplate.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(Organization $org, $id)
    {
        /** @var DocumentGenerationTemplate $documentGenerationTemplate */
        $documentGenerationTemplate = DocumentGenerationTemplate::find($id);

        if (empty($documentGenerationTemplate)) {
            //Flash::error('Document Generation Template not found');

            return redirect(route('fc.documentGenerationTemplates.index'));
        }

        return view('hasob-foundation-core::pages.document_generation_templates.show')->with('documentGenerationTemplate', $documentGenerationTemplate);
    }

    /**
     * Show the form for editing the specified DocumentGenerationTemplate.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Organization $org, $id)
    {
        /** @var DocumentGenerationTemplate $documentGenerationTemplate */
        $documentGenerationTemplate = DocumentGenerationTemplate::find($id);

        if (empty($documentGenerationTemplate)) {
            //Flash::error('Document Generation Template not found');

            return redirect(route('fc.documentGenerationTemplates.index'));
        }

        return view('hasob-foundation-core::pages.document_generation_templates.edit')->with('documentGenerationTemplate', $documentGenerationTemplate);
    }

    /**
     * Update the specified DocumentGenerationTemplate in storage.
     *
     * @param  int              $id
     * @param UpdateDocumentGenerationTemplateRequest $request
     *
     * @return Response
     */
    public function update(Organization $org, $id, UpdateDocumentGenerationTemplateRequest $request)
    {
        /** @var DocumentGenerationTemplate $documentGenerationTemplate */
        $documentGenerationTemplate = DocumentGenerationTemplate::find($id);

        if (empty($documentGenerationTemplate)) {
            //Flash::error('Document Generation Template not found');

            return redirect(route('fc.documentGenerationTemplates.index'));
        }

        $documentGenerationTemplate->fill($request->all());
        $documentGenerationTemplate->save();

        //Flash::success('Document Generation Template updated successfully.');
        
        DocumentGenerationTemplateUpdated::dispatch($documentGenerationTemplate);
        return redirect(route('fc.documentGenerationTemplates.index'));
    }

    /**
     * Remove the specified DocumentGenerationTemplate from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Organization $org, $id)
    {
        /** @var DocumentGenerationTemplate $documentGenerationTemplate */
        $documentGenerationTemplate = DocumentGenerationTemplate::find($id);

        if (empty($documentGenerationTemplate)) {
            //Flash::error('Document Generation Template not found');

            return redirect(route('fc.documentGenerationTemplates.index'));
        }

        $documentGenerationTemplate->delete();

        //Flash::success('Document Generation Template deleted successfully.');
        DocumentGenerationTemplateDeleted::dispatch($documentGenerationTemplate);
        return redirect(route('fc.documentGenerationTemplates.index'));
    }

        
    public function processBulkUpload(Organization $org, Request $request){

        $attachedFileName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('uploads'), $attachedFileName);
        $path_to_file = public_path('uploads').'/'.$attachedFileName;

        //Process each line
        $loop = 1;
        $errors = [];
        $lines = file($path_to_file);

        if (count($lines) > 1) {
            foreach ($lines as $line) {
                
                if ($loop > 1) {
                    $data = explode(',', $line);
                    // if (count($invalids) > 0) {
                    //     array_push($errors, $invalids);
                    //     continue;
                    // }else{
                    //     //Check if line is valid
                    //     if (!$valid) {
                    //         $errors[] = $msg;
                    //     }
                    // }
                }
                $loop++;
            }
        }else{
            $errors[] = 'The uploaded csv file is empty';
        }
        
        if (count($errors) > 0) {
            return $this->sendError($this->array_flatten($errors), 'Errors processing file');
        }
        return $this->sendResponse($subject->toArray(), 'Bulk upload completed successfully');
    }
}
