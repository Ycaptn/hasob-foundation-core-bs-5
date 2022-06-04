<?php

namespace Hasob\FoundationCore\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hasob\FoundationCore\Models\Taggable;

use Hasob\FoundationCore\Events\TaggableCreated;
use Hasob\FoundationCore\Events\TaggableUpdated;
use Hasob\FoundationCore\Events\TaggableDeleted;

use Hasob\FoundationCore\Requests\API\CreateTaggableAPIRequest;
use Hasob\FoundationCore\Requests\API\UpdateTaggableAPIRequest;

use Hasob\FoundationCore\Traits\ApiResponder;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;

/**
 * Class TaggableController
 * @package Hasob\FoundationCore\Controllers\API
 */

class TaggableAPIController extends AppBaseController
{

    use ApiResponder;

    /**
     * Display a listing of the Taggable.
     * GET|HEAD /taggables
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = Taggable::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        
        if ($organization != null){
            $query->where('organization_id', $organization->id);
        }

        $taggables = $this->showAll($query->get());

        return $this->sendResponse($taggables->toArray(), 'Taggables retrieved successfully');
    }

    /**
     * Store a newly created Taggable in storage.
     * POST /taggables
     *
     * @param CreateTaggableAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateTaggableAPIRequest $request, Organization $organization)
    {
        $input = $request->all();

        /** @var Taggable $taggable */
        $taggable = Taggable::create($input);
        
        TaggableCreated::dispatch($taggable);
        return $this->sendResponse($taggable->toArray(), 'Taggable saved successfully');
    }

    /**
     * Display the specified Taggable.
     * GET|HEAD /taggables/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        /** @var Taggable $taggable */
        $taggable = Taggable::find($id);

        if (empty($taggable)) {
            return $this->sendError('Taggable not found');
        }

        return $this->sendResponse($taggable->toArray(), 'Taggable retrieved successfully');
    }

    /**
     * Update the specified Taggable in storage.
     * PUT/PATCH /taggables/{id}
     *
     * @param int $id
     * @param UpdateTaggableAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTaggableAPIRequest $request, Organization $organization)
    {
        /** @var Taggable $taggable */
        $taggable = Taggable::find($id);

        if (empty($taggable)) {
            return $this->sendError('Taggable not found');
        }

        $taggable->fill($request->all());
        $taggable->save();
        
        TaggableUpdated::dispatch($taggable);
        return $this->sendResponse($taggable->toArray(), 'Taggable updated successfully');
    }

    /**
     * Remove the specified Taggable from storage.
     * DELETE /taggables/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Organization $organization)
    {
        /** @var Taggable $taggable */
        $taggable = Taggable::find($id);

        if (empty($taggable)) {
            return $this->sendError('Taggable not found');
        }

        $taggable->delete();
        TaggableDeleted::dispatch($taggable);
        return $this->sendSuccess('Taggable deleted successfully');
    }
}
