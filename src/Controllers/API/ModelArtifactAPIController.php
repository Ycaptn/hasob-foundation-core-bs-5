<?php

namespace Hasob\FoundationCore\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hasob\FoundationCore\Models\ModelArtifact;

use Hasob\FoundationCore\Events\ModelArtifactCreated;
use Hasob\FoundationCore\Events\ModelArtifactUpdated;
use Hasob\FoundationCore\Events\ModelArtifactDeleted;

use Hasob\FoundationCore\Requests\API\CreateModelArtifactAPIRequest;
use Hasob\FoundationCore\Requests\API\UpdateModelArtifactAPIRequest;

use Hasob\FoundationCore\Traits\ApiResponder;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;

/**
 * Class ModelArtifactController
 * @package Hasob\FoundationCore\Controllers\API
 */

class ModelArtifactAPIController extends AppBaseController
{

    use ApiResponder;

    /**
     * Display a listing of the ModelArtifact.
     * GET|HEAD /modelArtifacts
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = ModelArtifact::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        
        if ($organization != null){
            $query->where('organization_id', $organization->id);
        }

        $modelArtifacts = $this->showAll($query->get());

        return $this->sendResponse($modelArtifacts->toArray(), 'Model Artifacts retrieved successfully');
    }

    /**
     * Store a newly created ModelArtifact in storage.
     * POST /modelArtifacts
     *
     * @param CreateModelArtifactAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateModelArtifactAPIRequest $request, Organization $organization)
    {
        $input = $request->all();

        /** @var ModelArtifact $modelArtifact */
        $modelArtifact = ModelArtifact::create($input);
        
        ModelArtifactCreated::dispatch($modelArtifact);
        return $this->sendResponse($modelArtifact->toArray(), 'Model Artifact saved successfully');
    }

    /**
     * Display the specified ModelArtifact.
     * GET|HEAD /modelArtifacts/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        /** @var ModelArtifact $modelArtifact */
        $modelArtifact = ModelArtifact::find($id);

        if (empty($modelArtifact)) {
            return $this->sendError('Model Artifact not found');
        }

        return $this->sendResponse($modelArtifact->toArray(), 'Model Artifact retrieved successfully');
    }

    /**
     * Update the specified ModelArtifact in storage.
     * PUT/PATCH /modelArtifacts/{id}
     *
     * @param int $id
     * @param UpdateModelArtifactAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateModelArtifactAPIRequest $request, Organization $organization)
    {
        /** @var ModelArtifact $modelArtifact */
        $modelArtifact = ModelArtifact::find($id);

        if (empty($modelArtifact)) {
            return $this->sendError('Model Artifact not found');
        }

        $modelArtifact->fill($request->all());
        $modelArtifact->save();
        
        ModelArtifactUpdated::dispatch($modelArtifact);
        return $this->sendResponse($modelArtifact->toArray(), 'ModelArtifact updated successfully');
    }

    /**
     * Remove the specified ModelArtifact from storage.
     * DELETE /modelArtifacts/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Organization $organization)
    {
        /** @var ModelArtifact $modelArtifact */
        $modelArtifact = ModelArtifact::find($id);

        if (empty($modelArtifact)) {
            return $this->sendError('Model Artifact not found');
        }

        $modelArtifact->delete();
        ModelArtifactDeleted::dispatch($modelArtifact);
        return $this->sendSuccess('Model Artifact deleted successfully');
    }
}
