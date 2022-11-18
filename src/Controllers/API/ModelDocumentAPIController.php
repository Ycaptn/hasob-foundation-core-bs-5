<?php

namespace Hasob\FoundationCore\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hasob\FoundationCore\Models\ModelDocument;

use Hasob\FoundationCore\Events\ModelDocumentCreated;
use Hasob\FoundationCore\Events\ModelDocumentUpdated;
use Hasob\FoundationCore\Events\ModelDocumentDeleted;

use Hasob\FoundationCore\Requests\API\CreateModelDocumentAPIRequest;
use Hasob\FoundationCore\Requests\API\UpdateModelDocumentAPIRequest;

use Hasob\FoundationCore\Traits\ApiResponder;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;

/**
 * Class ModelDocumentController
 * @package Hasob\FoundationCore\Controllers\API
 */

class ModelDocumentAPIController extends AppBaseController
{

    use ApiResponder;

    /**
     * Display a listing of the ModelDocument.
     * GET|HEAD /modelDocuments
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = ModelDocument::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        
        if ($organization != null){
            $query->where('organization_id', $organization->id);
        }

        $modelDocuments = $this->showAll($query->get());

        return $this->sendResponse($modelDocuments->toArray(), 'Model Documents retrieved successfully');
    }

    /**
     * Store a newly created ModelDocument in storage.
     * POST /modelDocuments
     *
     * @param CreateModelDocumentAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateModelDocumentAPIRequest $request, Organization $organization)
    {
        $input = $request->all();

        /** @var ModelDocument $modelDocument */
        $modelDocument = ModelDocument::create($input);
        
        ModelDocumentCreated::dispatch($modelDocument);
        return $this->sendResponse($modelDocument->toArray(), 'Model Document saved successfully');
    }

    /**
     * Display the specified ModelDocument.
     * GET|HEAD /modelDocuments/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        /** @var ModelDocument $modelDocument */
        $modelDocument = ModelDocument::find($id);

        if (empty($modelDocument)) {
            return $this->sendError('Model Document not found');
        }

        return $this->sendResponse($modelDocument->toArray(), 'Model Document retrieved successfully');
    }

    /**
     * Update the specified ModelDocument in storage.
     * PUT/PATCH /modelDocuments/{id}
     *
     * @param int $id
     * @param UpdateModelDocumentAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateModelDocumentAPIRequest $request, Organization $organization)
    {
        /** @var ModelDocument $modelDocument */
        $modelDocument = ModelDocument::find($id);

        if (empty($modelDocument)) {
            return $this->sendError('Model Document not found');
        }

        $modelDocument->fill($request->all());
        $modelDocument->save();
        
        ModelDocumentUpdated::dispatch($modelDocument);
        return $this->sendResponse($modelDocument->toArray(), 'ModelDocument updated successfully');
    }

    /**
     * Remove the specified ModelDocument from storage.
     * DELETE /modelDocuments/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Organization $organization)
    {
        /** @var ModelDocument $modelDocument */
        $modelDocument = ModelDocument::find($id);

        if (empty($modelDocument)) {
            return $this->sendError('Model Document not found');
        }

        $modelDocument->delete();
        ModelDocumentDeleted::dispatch($modelDocument);
        return $this->sendSuccess('Model Document deleted successfully');
    }
}
