<?php

namespace Hasob\FoundationCore\Controllers;

use Hasob\FoundationCore\Models\ModelDocument;

use Hasob\FoundationCore\Events\ModelDocumentCreated;
use Hasob\FoundationCore\Events\ModelDocumentUpdated;
use Hasob\FoundationCore\Events\ModelDocumentDeleted;

use Hasob\FoundationCore\Requests\CreateModelDocumentRequest;
use Hasob\FoundationCore\Requests\UpdateModelDocumentRequest;

use Hasob\FoundationCore\DataTables\ModelDocumentDataTable;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;

use Flash;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class ModelDocumentController extends BaseController
{
    /**
     * Display a listing of the ModelDocument.
     *
     * @param ModelDocumentDataTable $modelDocumentDataTable
     * @return Response
     */
    public function index(Organization $org, ModelDocumentDataTable $modelDocumentDataTable)
    {
        $current_user = Auth()->user();

        $cdv_model_documents = new \Hasob\FoundationCore\View\Components\CardDataView(ModelDocument::class, "hasob-foundation-core::model_documents.card_view_item");
        $cdv_model_documents->setDataQuery(['organization_id'=>$org->id])
                        //->addDataGroup('label','field','value')
                        //->setSearchFields(['field_to_search1','field_to_search2'])
                        //->addDataOrder('display_ordinal','DESC')
                        //->addDataOrder('id','DESC')
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(20)
                        ->setSearchPlaceholder('Search ModelDocument');

        if (request()->expectsJson()){
            return $cdv_model_documents->render();
        }

        return view('hasob-foundation-core::model_documents.card_view_index')
                    ->with('current_user', $current_user)
                    ->with('months_list', BaseController::monthsList())
                    ->with('states_list', BaseController::statesList())
                    ->with('cdv_model_documents', $cdv_model_documents);

        /*
        return $modelDocumentDataTable->render('hasob-foundation-core::pages.model_documents.index',[
            'current_user'=>$current_user,
            'months_list'=>BaseController::monthsList(),
            'states_list'=>BaseController::statesList()
        ]);
        */
    }

    /**
     * Show the form for creating a new ModelDocument.
     *
     * @return Response
     */
    public function create(Organization $org)
    {
        return view('hasob-foundation-core::pages.model_documents.create');
    }

    /**
     * Store a newly created ModelDocument in storage.
     *
     * @param CreateModelDocumentRequest $request
     *
     * @return Response
     */
    public function store(Organization $org, CreateModelDocumentRequest $request)
    {
        $input = $request->all();

        /** @var ModelDocument $modelDocument */
        $modelDocument = ModelDocument::create($input);

        //Flash::success('Model Document saved successfully.');

        ModelDocumentCreated::dispatch($modelDocument);
        return redirect(route('fc.modelDocuments.index'));
    }

    /**
     * Display the specified ModelDocument.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(Organization $org, $id)
    {
        /** @var ModelDocument $modelDocument */
        $modelDocument = ModelDocument::find($id);

        if (empty($modelDocument)) {
            //Flash::error('Model Document not found');

            return redirect(route('fc.modelDocuments.index'));
        }

        return view('hasob-foundation-core::pages.model_documents.show')->with('modelDocument', $modelDocument);
    }

    /**
     * Show the form for editing the specified ModelDocument.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Organization $org, $id)
    {
        /** @var ModelDocument $modelDocument */
        $modelDocument = ModelDocument::find($id);

        if (empty($modelDocument)) {
            //Flash::error('Model Document not found');

            return redirect(route('fc.modelDocuments.index'));
        }

        return view('hasob-foundation-core::pages.model_documents.edit')->with('modelDocument', $modelDocument);
    }

    /**
     * Update the specified ModelDocument in storage.
     *
     * @param  int              $id
     * @param UpdateModelDocumentRequest $request
     *
     * @return Response
     */
    public function update(Organization $org, $id, UpdateModelDocumentRequest $request)
    {
        /** @var ModelDocument $modelDocument */
        $modelDocument = ModelDocument::find($id);

        if (empty($modelDocument)) {
            //Flash::error('Model Document not found');

            return redirect(route('fc.modelDocuments.index'));
        }

        $modelDocument->fill($request->all());
        $modelDocument->save();

        //Flash::success('Model Document updated successfully.');
        
        ModelDocumentUpdated::dispatch($modelDocument);
        return redirect(route('fc.modelDocuments.index'));
    }

    /**
     * Remove the specified ModelDocument from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Organization $org, $id)
    {
        /** @var ModelDocument $modelDocument */
        $modelDocument = ModelDocument::find($id);

        if (empty($modelDocument)) {
            //Flash::error('Model Document not found');

            return redirect(route('fc.modelDocuments.index'));
        }

        $modelDocument->delete();

        //Flash::success('Model Document deleted successfully.');
        ModelDocumentDeleted::dispatch($modelDocument);
        return redirect(route('fc.modelDocuments.index'));
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
