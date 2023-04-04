<?php

namespace Hasob\FoundationCore\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hasob\FoundationCore\Models\Comment;

use Hasob\FoundationCore\Requests\API\CreateCommentAPIRequest;

use Hasob\FoundationCore\Traits\ApiResponder;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;

/**
 * Class CommentAPIController
 * @package Hasob\FoundationCore\Controllers\API
 */

class CommentAPIController extends AppBaseController
{

    use ApiResponder;

    /**
     * Display a listing of the Comment.
     * GET|HEAD /comments
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = Comment::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        
        if ($organization != null){
            $query->where('organization_id', $organization->id);
        }

        $comments = $this->showAll($query->get());

        return $this->sendResponse($comments->toArray(), 'Commentes retrieved successfully');
    }

    /**
     * Store a newly created Comment in storage.
     * POST /comments
     *
     * @param CreateCommentAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCommentAPIRequest $request, Organization $organization)
    {   
        $input = $request->all();

        if ($request->has('commentable_type') && $request->commentable_type == 'workItem') {
            $work_item = \Hasob\Workflow\Models\WorkItem::find($request->commentable_id);
            if (empty($work_item)) {
                return $this->sendError('WorkItem record was not found.');
            }

            $workable = $work_item->workable;
            $input['commentable_type'] = get_class($workable) ?? null;
        }

        /** @var Comment $comment */
        $comment = new Comment();
        $comment->user_id = auth()->user()->id;
        $comment->content = $input['content'];
        $comment->commentable_id = $input['commentable_id'];
        $comment->commentable_type = $input['commentable_type'];
        $comment->organization_id = $organization->organization_id;
        $comment->save();
        
        return $this->sendResponse($comment->toArray(), 'New Comment saved successfully');
    }

    /**
     * Display the specified Comment.
     * GET|HEAD /comments/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        /** @var Comment $comment */
        $comment = Comment::find($id);

        if (empty($comment)) {
            return $this->sendError('Comment not found');
        }

        return $this->sendResponse($comment->toArray(), 'Comment retrieved successfully');
    }

    /**
     * Update the specified Comment in storage.
     * PUT/PATCH /comments/{id}
     *
     * @param int $id
     * @param UpdateCommentAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCommentAPIRequest $request, Organization $organization)
    {
        /** @var Comment $comment */
        $comment = Comment::find($id);

        if (empty($comment)) {
            return $this->sendError('Comment not found');
        }

        $comment->fill($request->all());
        $comment->save();
        
        CommentUpdated::dispatch($comment);
        return $this->sendResponse($comment->toArray(), 'Comment updated successfully');
    }

    /**
     * Remove the specified Comment from storage.
     * DELETE /comments/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Organization $organization)
    {
        /** @var Comment $comment */
        $comment = Comment::find($id);

        if (empty($comment)) {
            return $this->sendError('Comment not found');
        }

        $comment->delete();
        CommentDeleted::dispatch($comment);
        return $this->sendSuccess('Comment deleted successfully');
    }
}
