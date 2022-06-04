<?php

namespace Hasob\FoundationCore\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hasob\FoundationCore\Models\FiscalYearPeriod;

use Hasob\FoundationCore\Events\FiscalYearPeriodCreated;
use Hasob\FoundationCore\Events\FiscalYearPeriodUpdated;
use Hasob\FoundationCore\Events\FiscalYearPeriodDeleted;

use Hasob\FoundationCore\Requests\API\CreateFiscalYearPeriodAPIRequest;
use Hasob\FoundationCore\Requests\API\UpdateFiscalYearPeriodAPIRequest;

use Hasob\FoundationCore\Traits\ApiResponder;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;

/**
 * Class FiscalYearPeriodController
 * @package Hasob\FoundationCore\Controllers\API
 */

class FiscalYearPeriodAPIController extends AppBaseController
{

    use ApiResponder;

    /**
     * Display a listing of the FiscalYearPeriod.
     * GET|HEAD /fiscalYearPeriods
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = FiscalYearPeriod::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        
        if ($organization != null){
            $query->where('organization_id', $organization->id);
        }

        $fiscalYearPeriods = $this->showAll($query->get());

        return $this->sendResponse($fiscalYearPeriods->toArray(), 'Fiscal Year Periods retrieved successfully');
    }

    /**
     * Store a newly created FiscalYearPeriod in storage.
     * POST /fiscalYearPeriods
     *
     * @param CreateFiscalYearPeriodAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFiscalYearPeriodAPIRequest $request, Organization $organization)
    {
        $input = $request->all();

        /** @var FiscalYearPeriod $fiscalYearPeriod */
        $fiscalYearPeriod = FiscalYearPeriod::create($input);
        
        FiscalYearPeriodCreated::dispatch($fiscalYearPeriod);
        return $this->sendResponse($fiscalYearPeriod->toArray(), 'Fiscal Year Period saved successfully');
    }

    /**
     * Display the specified FiscalYearPeriod.
     * GET|HEAD /fiscalYearPeriods/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        /** @var FiscalYearPeriod $fiscalYearPeriod */
        $fiscalYearPeriod = FiscalYearPeriod::find($id);

        if (empty($fiscalYearPeriod)) {
            return $this->sendError('Fiscal Year Period not found');
        }

        return $this->sendResponse($fiscalYearPeriod->toArray(), 'Fiscal Year Period retrieved successfully');
    }

    /**
     * Update the specified FiscalYearPeriod in storage.
     * PUT/PATCH /fiscalYearPeriods/{id}
     *
     * @param int $id
     * @param UpdateFiscalYearPeriodAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFiscalYearPeriodAPIRequest $request, Organization $organization)
    {
        /** @var FiscalYearPeriod $fiscalYearPeriod */
        $fiscalYearPeriod = FiscalYearPeriod::find($id);

        if (empty($fiscalYearPeriod)) {
            return $this->sendError('Fiscal Year Period not found');
        }

        $fiscalYearPeriod->fill($request->all());
        $fiscalYearPeriod->save();
        
        FiscalYearPeriodUpdated::dispatch($fiscalYearPeriod);
        return $this->sendResponse($fiscalYearPeriod->toArray(), 'FiscalYearPeriod updated successfully');
    }

    /**
     * Remove the specified FiscalYearPeriod from storage.
     * DELETE /fiscalYearPeriods/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Organization $organization)
    {
        /** @var FiscalYearPeriod $fiscalYearPeriod */
        $fiscalYearPeriod = FiscalYearPeriod::find($id);

        if (empty($fiscalYearPeriod)) {
            return $this->sendError('Fiscal Year Period not found');
        }

        $fiscalYearPeriod->delete();
        FiscalYearPeriodDeleted::dispatch($fiscalYearPeriod);
        return $this->sendSuccess('Fiscal Year Period deleted successfully');
    }
}
