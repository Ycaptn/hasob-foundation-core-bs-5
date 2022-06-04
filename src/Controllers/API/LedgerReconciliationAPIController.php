<?php

namespace Hasob\FoundationCore\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hasob\FoundationCore\Models\LedgerReconciliation;

use Hasob\FoundationCore\Events\LedgerReconciliationCreated;
use Hasob\FoundationCore\Events\LedgerReconciliationUpdated;
use Hasob\FoundationCore\Events\LedgerReconciliationDeleted;

use Hasob\FoundationCore\Requests\API\CreateLedgerReconciliationAPIRequest;
use Hasob\FoundationCore\Requests\API\UpdateLedgerReconciliationAPIRequest;

use Hasob\FoundationCore\Traits\ApiResponder;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;

/**
 * Class LedgerReconciliationController
 * @package Hasob\FoundationCore\Controllers\API
 */

class LedgerReconciliationAPIController extends AppBaseController
{

    use ApiResponder;

    /**
     * Display a listing of the LedgerReconciliation.
     * GET|HEAD /ledgerReconciliations
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = LedgerReconciliation::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        
        if ($organization != null){
            $query->where('organization_id', $organization->id);
        }

        $ledgerReconciliations = $this->showAll($query->get());

        return $this->sendResponse($ledgerReconciliations->toArray(), 'Ledger Reconciliations retrieved successfully');
    }

    /**
     * Store a newly created LedgerReconciliation in storage.
     * POST /ledgerReconciliations
     *
     * @param CreateLedgerReconciliationAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateLedgerReconciliationAPIRequest $request, Organization $organization)
    {
        $input = $request->all();

        /** @var LedgerReconciliation $ledgerReconciliation */
        $ledgerReconciliation = LedgerReconciliation::create($input);
        
        LedgerReconciliationCreated::dispatch($ledgerReconciliation);
        return $this->sendResponse($ledgerReconciliation->toArray(), 'Ledger Reconciliation saved successfully');
    }

    /**
     * Display the specified LedgerReconciliation.
     * GET|HEAD /ledgerReconciliations/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        /** @var LedgerReconciliation $ledgerReconciliation */
        $ledgerReconciliation = LedgerReconciliation::find($id);

        if (empty($ledgerReconciliation)) {
            return $this->sendError('Ledger Reconciliation not found');
        }

        return $this->sendResponse($ledgerReconciliation->toArray(), 'Ledger Reconciliation retrieved successfully');
    }

    /**
     * Update the specified LedgerReconciliation in storage.
     * PUT/PATCH /ledgerReconciliations/{id}
     *
     * @param int $id
     * @param UpdateLedgerReconciliationAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLedgerReconciliationAPIRequest $request, Organization $organization)
    {
        /** @var LedgerReconciliation $ledgerReconciliation */
        $ledgerReconciliation = LedgerReconciliation::find($id);

        if (empty($ledgerReconciliation)) {
            return $this->sendError('Ledger Reconciliation not found');
        }

        $ledgerReconciliation->fill($request->all());
        $ledgerReconciliation->save();
        
        LedgerReconciliationUpdated::dispatch($ledgerReconciliation);
        return $this->sendResponse($ledgerReconciliation->toArray(), 'LedgerReconciliation updated successfully');
    }

    /**
     * Remove the specified LedgerReconciliation from storage.
     * DELETE /ledgerReconciliations/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Organization $organization)
    {
        /** @var LedgerReconciliation $ledgerReconciliation */
        $ledgerReconciliation = LedgerReconciliation::find($id);

        if (empty($ledgerReconciliation)) {
            return $this->sendError('Ledger Reconciliation not found');
        }

        $ledgerReconciliation->delete();
        LedgerReconciliationDeleted::dispatch($ledgerReconciliation);
        return $this->sendSuccess('Ledger Reconciliation deleted successfully');
    }
}
