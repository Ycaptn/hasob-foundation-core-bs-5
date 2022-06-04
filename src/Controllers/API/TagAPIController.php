<?php

namespace Hasob\FoundationCore\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hasob\FoundationCore\Models\Tag;

use Hasob\FoundationCore\Events\TagCreated;
use Hasob\FoundationCore\Events\TagUpdated;
use Hasob\FoundationCore\Events\TagDeleted;

use Hasob\FoundationCore\Requests\API\CreateTagAPIRequest;
use Hasob\FoundationCore\Requests\API\UpdateTagAPIRequest;

use Hasob\FoundationCore\Traits\ApiResponder;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;

/**
 * Class TagController
 * @package Hasob\FoundationCore\Controllers\API
 */

class TagAPIController extends AppBaseController
{

    use ApiResponder;

    /**
     * Display a listing of the Tag.
     * GET|HEAD /tags
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = Tag::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        
        if ($organization != null){
            $query->where('organization_id', $organization->id);
        }

        $tags = $this->showAll($query->get());

        return $this->sendResponse($tags->toArray(), 'Tags retrieved successfully');
    }

    /**
     * Store a newly created Tag in storage.
     * POST /tags
     *
     * @param CreateTagAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateTagAPIRequest $request, Organization $organization)
    {
        $input = $request->all();
        $current_user = Auth()->user();

        //Check if the tag already exists
        //Add the user name if the user is logged in
        $tag = Tag::where('name', $request->name)->where('parent_id',null)->first();
        if ($tag == null){
            $tag = Tag::create($input);
            $tag->user_id = $current_user->id;
            $tag->save();

            TagCreated::dispatch($tag);
        }
        
        return $this->sendResponse($tag->toArray(), 'Tag saved successfully');
    }

    /**
     * Display the specified Tag.
     * GET|HEAD /tags/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        /** @var Tag $tag */
        $tag = Tag::find($id);

        if (empty($tag)) {
            return $this->sendError('Tag not found');
        }

        return $this->sendResponse($tag->toArray(), 'Tag retrieved successfully');
    }

    /**
     * Update the specified Tag in storage.
     * PUT/PATCH /tags/{id}
     *
     * @param int $id
     * @param UpdateTagAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTagAPIRequest $request, Organization $organization)
    {
        /** @var Tag $tag */
        $tag = Tag::find($id);

        if (empty($tag)) {
            return $this->sendError('Tag not found');
        }

        $tag->fill($request->all());
        $tag->save();
        
        TagUpdated::dispatch($tag);
        return $this->sendResponse($tag->toArray(), 'Tag updated successfully');
    }

    /**
     * Remove the specified Tag from storage.
     * DELETE /tags/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Organization $organization)
    {
        /** @var Tag $tag */
        $tag = Tag::find($id);

        if (empty($tag)) {
            return $this->sendError('Tag not found');
        }

        $tag->delete();
        TagDeleted::dispatch($tag);
        return $this->sendSuccess('Tag deleted successfully');
    }
}
