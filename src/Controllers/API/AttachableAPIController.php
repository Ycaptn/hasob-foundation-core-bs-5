<?php

namespace Hasob\FoundationCore\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hasob\FoundationCore\Models\Attachable;


use Hasob\FoundationCore\Traits\ApiResponder;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;

/**
 * Class AttachableController
 * @package Hasob\FoundationCore\Controllers\API
 */

class AttachableAPIController extends AppBaseController
{

    use ApiResponder;

    /**
     * Display a listing of the Attachable.
     * GET|HEAD /Attachablees
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = Attachable::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        
        $attachables = $this->showAll($query->get());

        return $this->sendResponse($attachables->toArray(), 'Attachables retrieved successfully');
    }

    /**
     * Store a newly created Attachable in storage.
     * POST /Attachables
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request, Organization $organization)
    {
        $input = $request->all();

        /** @var Attachable $attachable */
        $attachable = Attachable::create($input);
        
        return $this->sendResponse($attachable->toArray(), 'Attachable saved successfully');
    }

    /**
     * Display the specified Attachable.
     * GET|HEAD /Attachables/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        /** @var Attachable $Attachable */
        $attachable = Attachable::find($id);

        if (empty($attachable)) {
            return $this->sendError('Attachable not found');
        }

        return $this->sendResponse($attachable->toArray(), 'Attachable retrieved successfully');
    }

    /**
     * Update the specified Attachable in storage.
     * PUT/PATCH /Attachablees/{id}
     *
     * @param int $id
     * @param Request $request
     *
     * @return Response
     */
    public function update($id, Request $request, Organization $organization)
    {
        /** @var Attachable $Attachable */
        $attachable = Attachable::find($id);

        if (empty($attachable)) {
            return $this->sendError('Attachable not found');
        }

        $attachable->fill($request->all());
        $attachable->save();
        
        return $this->sendResponse($attachable->toArray(), 'Attachable updated successfully');
    }

    /**
     * Remove the specified Attachable from storage.
     * DELETE /Attachables/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Organization $organization)
    {
        /** @var Attachable $Attachable */
        $attachable = Attachable::find($id);

        if (empty($attachable)) {
            return $this->sendError('Attachable not found');
        }

        $attachable->delete();
        return $this->sendSuccess('Attachable deleted successfully');
    }
}
