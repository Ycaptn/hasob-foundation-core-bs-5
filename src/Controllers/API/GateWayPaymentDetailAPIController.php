<?php

namespace Hasob\FoundationCore\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hasob\FoundationCore\Models\GateWayPaymentDetail;

use Hasob\FoundationCore\Events\GateWayPaymentDetailCreated;
use Hasob\FoundationCore\Events\GateWayPaymentDetailUpdated;
use Hasob\FoundationCore\Events\GateWayPaymentDetailDeleted;

use Hasob\FoundationCore\Requests\API\CreateGateWayPaymentDetailAPIRequest;
use Hasob\FoundationCore\Requests\API\UpdateGateWayPaymentDetailAPIRequest;

use Hasob\FoundationCore\Traits\ApiResponder;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;

/**
 * Class GateWayPaymentDetailController
 * @package Hasob\FoundationCore\Controllers\API
 */

class GateWayPaymentDetailAPIController extends AppBaseController
{

    use ApiResponder;

    /**
     * Display a listing of the GateWayPaymentDetail.
     * GET|HEAD /gateWayPaymentDetails
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = GateWayPaymentDetail::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        
        if ($organization != null){
            $query->where('organization_id', $organization->id);
        }

        $gateWayPaymentDetails = $this->showAll($query->get());

        return $this->sendResponse($gateWayPaymentDetails->toArray(), 'Gate Way Payment Details retrieved successfully');
    }

    /**
     * Store a newly created GateWayPaymentDetail in storage.
     * POST /gateWayPaymentDetails
     *
     * @param CreateGateWayPaymentDetailAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateGateWayPaymentDetailAPIRequest $request, Organization $organization)
    {
        $input = $request->all();

        /** @var GateWayPaymentDetail $gateWayPaymentDetail */
        $gateWayPaymentDetail = GateWayPaymentDetail::create($input);
        
        GateWayPaymentDetailCreated::dispatch($gateWayPaymentDetail);
        return $this->sendResponse($gateWayPaymentDetail->toArray(), 'Gate Way Payment Detail saved successfully');
    }

    /**
     * Display the specified GateWayPaymentDetail.
     * GET|HEAD /gateWayPaymentDetails/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        /** @var GateWayPaymentDetail $gateWayPaymentDetail */
        $gateWayPaymentDetail = GateWayPaymentDetail::find($id);

        if (empty($gateWayPaymentDetail)) {
            return $this->sendError('Gate Way Payment Detail not found');
        }

        return $this->sendResponse($gateWayPaymentDetail->toArray(), 'Gate Way Payment Detail retrieved successfully');
    }

    /**
     * Update the specified GateWayPaymentDetail in storage.
     * PUT/PATCH /gateWayPaymentDetails/{id}
     *
     * @param int $id
     * @param UpdateGateWayPaymentDetailAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGateWayPaymentDetailAPIRequest $request, Organization $organization)
    {
        /** @var GateWayPaymentDetail $gateWayPaymentDetail */
        $gateWayPaymentDetail = GateWayPaymentDetail::find($id);

        if (empty($gateWayPaymentDetail)) {
            return $this->sendError('Gate Way Payment Detail not found');
        }

        $gateWayPaymentDetail->fill($request->all());
        $gateWayPaymentDetail->save();
        
        GateWayPaymentDetailUpdated::dispatch($gateWayPaymentDetail);
        return $this->sendResponse($gateWayPaymentDetail->toArray(), 'GateWayPaymentDetail updated successfully');
    }

    /**
     * Remove the specified GateWayPaymentDetail from storage.
     * DELETE /gateWayPaymentDetails/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Organization $organization)
    {
        /** @var GateWayPaymentDetail $gateWayPaymentDetail */
        $gateWayPaymentDetail = GateWayPaymentDetail::find($id);

        if (empty($gateWayPaymentDetail)) {
            return $this->sendError('Gate Way Payment Detail not found');
        }

        $gateWayPaymentDetail->delete();
        GateWayPaymentDetailDeleted::dispatch($gateWayPaymentDetail);
        return $this->sendSuccess('Gate Way Payment Detail deleted successfully');
    }
}
