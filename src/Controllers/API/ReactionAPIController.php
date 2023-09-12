<?php

namespace Hasob\FoundationCore\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hasob\FoundationCore\Models\Reaction;

use Hasob\FoundationCore\Events\ReactionCreated;
use Hasob\FoundationCore\Events\ReactionUpdated;
use Hasob\FoundationCore\Events\ReactionDeleted;

use Hasob\FoundationCore\Requests\API\CreateReactionAPIRequest;
use Hasob\FoundationCore\Requests\API\UpdateReactionAPIRequest;

use Hasob\FoundationCore\Traits\ApiResponder;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;

/**
 * Class ReactionController
 * @package Hasob\FoundationCore\Controllers\API
 */

class ReactionAPIController extends AppBaseController
{

    use ApiResponder;

    /**
     * Display a listing of the Reaction.
     * GET|HEAD /reactions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = Reaction::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        
        if ($organization != null){
            $query->where('organization_id', $organization->id);
        }

        $reactions = $this->showAll($query->get());

        return $this->sendResponse($reactions->toArray(), 'Reactions retrieved successfully');
    }

    /**
     * Store a newly created Reaction in storage.
     * POST /reactions
     *
     * @param CreateReactionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateReactionAPIRequest $request, Organization $organization)
    {
        $input = $request->all();

        /** @var Reaction $reaction */
        $reaction = Reaction::create($input);
        
        ReactionCreated::dispatch($reaction);
        return $this->sendResponse($reaction->toArray(), 'Reaction saved successfully');
    }

    /**
     * Display the specified Reaction.
     * GET|HEAD /reactions/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        /** @var Reaction $reaction */
        $reaction = Reaction::find($id);

        if (empty($reaction)) {
            return $this->sendError('Reaction not found');
        }

        return $this->sendResponse($reaction->toArray(), 'Reaction retrieved successfully');
    }

    /**
     * Update the specified Reaction in storage.
     * PUT/PATCH /reactions/{id}
     *
     * @param int $id
     * @param UpdateReactionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateReactionAPIRequest $request, Organization $organization)
    {
        /** @var Reaction $reaction */
        $reaction = Reaction::find($id);

        if (empty($reaction)) {
            return $this->sendError('Reaction not found');
        }

        $reaction->fill($request->all());
        $reaction->save();
        
        ReactionUpdated::dispatch($reaction);
        return $this->sendResponse($reaction->toArray(), 'Reaction updated successfully');
    }

    /**
     * Remove the specified Reaction from storage.
     * DELETE /reactions/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Organization $organization)
    {
        /** @var Reaction $reaction */
        $reaction = Reaction::find($id);

        if (empty($reaction)) {
            return $this->sendError('Reaction not found');
        }

        $reaction->delete();
        ReactionDeleted::dispatch($reaction);
        return $this->sendSuccess('Reaction deleted successfully');
    }
}
