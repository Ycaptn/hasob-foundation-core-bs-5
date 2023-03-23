<?php

namespace Hasob\FoundationCore\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hasob\FoundationCore\Models\Support;

use Hasob\FoundationCore\Events\SupportCreated;
use Hasob\FoundationCore\Events\SupportUpdated;
use Hasob\FoundationCore\Events\SupportDeleted;

use Hasob\FoundationCore\Requests\API\CreateSupportAPIRequest;
use Hasob\FoundationCore\Requests\API\UpdateSupportAPIRequest;

use Hasob\FoundationCore\Traits\ApiResponder;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;

/**
 * Class SupportController
 * @package Hasob\FoundationCore\Controllers\API
 */

class SupportAPIController extends AppBaseController
{

    use ApiResponder;

    /**
     * Display a listing of the support.
     * GET|HEAD /supportes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = support::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        
        if ($organization != null){
            $query->where('organization_id', $organization->id);
        }

        $supportes = $this->showAll($query->get());

        return $this->sendResponse($supportes->toArray(), 'supportes retrieved successfully');
    }

    /**
     * Store a newly created support in storage.
     * POST /supportes
     *
     * @param CreateSupportAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSupportAPIRequest $request, Organization $organization)
    {
        $input = $request->all();

        /** @var Support $support */
        $support = Support::create($input);
        
        SupportCreated::dispatch($support);
        return $this->sendResponse($support->toArray(), 'support saved successfully');
    }

    /**
     * Display the specified support.
     * GET|HEAD /supportes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        /** @var support $support */
        $support = Support::find($id);

        if (empty($support)) {
            return $this->sendError('support not found');
        }

        return $this->sendResponse($support->toArray(), 'support retrieved successfully');
    }

    /**
     * Update the specified support in storage.
     * PUT/PATCH /supportes/{id}
     *
     * @param int $id
     * @param UpdatesupportAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatesupportAPIRequest $request, Organization $organization)
    {
        /** @var Support $support */
        $support = Support::find($id);

        if (empty($support)) {
            return $this->sendError('support not found');
        }

        $support->fill($request->all());
        $support->save();
        
        supportUpdated::dispatch($support);
        return $this->sendResponse($support->toArray(), 'support updated successfully');
    }

    /**
     * Remove the specified support from storage.
     * DELETE /supportes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Organization $organization)
    {
        /** @var Support $support */
        $support = Support::find($id);

        if (empty($support)) {
            return $this->sendError('support not found');
        }

        $support->delete();
        SupportDeleted::dispatch($support);
        return $this->sendSuccess('support deleted successfully');
    }
}
