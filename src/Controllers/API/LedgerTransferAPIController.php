<?php

namespace Hasob\FoundationCore\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hasob\FoundationCore\Models\LedgerTransfer;

use Hasob\FoundationCore\Events\LedgerTransferCreated;
use Hasob\FoundationCore\Events\LedgerTransferUpdated;
use Hasob\FoundationCore\Events\LedgerTransferDeleted;

use Hasob\FoundationCore\Requests\API\CreateLedgerTransferAPIRequest;
use Hasob\FoundationCore\Requests\API\UpdateLedgerTransferAPIRequest;

use Hasob\FoundationCore\Traits\ApiResponder;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;

/**
 * Class LedgerTransferController
 * @package Hasob\FoundationCore\Controllers\API
 */

class LedgerTransferAPIController extends AppBaseController
{

    use ApiResponder;

    /**
     * Display a listing of the LedgerTransfer.
     * GET|HEAD /ledgerTransfers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = LedgerTransfer::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        
        if ($organization != null){
            $query->where('organization_id', $organization->id);
        }

        $ledgerTransfers = $this->showAll($query->get());

        return $this->sendResponse($ledgerTransfers->toArray(), 'Ledger Transfers retrieved successfully');
    }

    /**
     * Store a newly created LedgerTransfer in storage.
     * POST /ledgerTransfers
     *
     * @param CreateLedgerTransferAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateLedgerTransferAPIRequest $request, Organization $organization)
    {
        $input = $request->all();

        /** @var LedgerTransfer $ledgerTransfer */
        $ledgerTransfer = LedgerTransfer::create($input);
        
        LedgerTransferCreated::dispatch($ledgerTransfer);
        return $this->sendResponse($ledgerTransfer->toArray(), 'Ledger Transfer saved successfully');
    }

    /**
     * Display the specified LedgerTransfer.
     * GET|HEAD /ledgerTransfers/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        /** @var LedgerTransfer $ledgerTransfer */
        $ledgerTransfer = LedgerTransfer::find($id);

        if (empty($ledgerTransfer)) {
            return $this->sendError('Ledger Transfer not found');
        }

        return $this->sendResponse($ledgerTransfer->toArray(), 'Ledger Transfer retrieved successfully');
    }

    /**
     * Update the specified LedgerTransfer in storage.
     * PUT/PATCH /ledgerTransfers/{id}
     *
     * @param int $id
     * @param UpdateLedgerTransferAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLedgerTransferAPIRequest $request, Organization $organization)
    {
        /** @var LedgerTransfer $ledgerTransfer */
        $ledgerTransfer = LedgerTransfer::find($id);

        if (empty($ledgerTransfer)) {
            return $this->sendError('Ledger Transfer not found');
        }

        $ledgerTransfer->fill($request->all());
        $ledgerTransfer->save();
        
        LedgerTransferUpdated::dispatch($ledgerTransfer);
        return $this->sendResponse($ledgerTransfer->toArray(), 'LedgerTransfer updated successfully');
    }

    /**
     * Remove the specified LedgerTransfer from storage.
     * DELETE /ledgerTransfers/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Organization $organization)
    {
        /** @var LedgerTransfer $ledgerTransfer */
        $ledgerTransfer = LedgerTransfer::find($id);

        if (empty($ledgerTransfer)) {
            return $this->sendError('Ledger Transfer not found');
        }

        $ledgerTransfer->delete();
        LedgerTransferDeleted::dispatch($ledgerTransfer);
        return $this->sendSuccess('Ledger Transfer deleted successfully');
    }
}
