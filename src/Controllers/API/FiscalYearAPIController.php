<?php

namespace Hasob\FoundationCore\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hasob\FoundationCore\Models\FiscalYear;

use Hasob\FoundationCore\Events\FiscalYearCreated;
use Hasob\FoundationCore\Events\FiscalYearUpdated;
use Hasob\FoundationCore\Events\FiscalYearDeleted;

use Hasob\FoundationCore\Requests\API\CreateFiscalYearAPIRequest;
use Hasob\FoundationCore\Requests\API\UpdateFiscalYearAPIRequest;

use Hasob\FoundationCore\Traits\ApiResponder;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;

/**
 * Class FiscalYearController
 * @package Hasob\FoundationCore\Controllers\API
 */

class FiscalYearAPIController extends AppBaseController
{

    use ApiResponder;

    /**
     * Display a listing of the FiscalYear.
     * GET|HEAD /fiscalYears
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = FiscalYear::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        
        if ($organization != null){
            $query->where('organization_id', $organization->id);
        }

        $fiscalYears = $this->showAll($query->get());

        return $this->sendResponse($fiscalYears->toArray(), 'Fiscal Years retrieved successfully');
    }

    /**
     * Store a newly created FiscalYear in storage.
     * POST /fiscalYears
     *
     * @param CreateFiscalYearAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFiscalYearAPIRequest $request, Organization $organization)
    {
        $input = $request->all();

        /** @var FiscalYear $fiscalYear */
        $fiscalYear = FiscalYear::create($input);
        
        FiscalYearCreated::dispatch($fiscalYear);
        return $this->sendResponse($fiscalYear->toArray(), 'Fiscal Year saved successfully');
    }

    /**
     * Display the specified FiscalYear.
     * GET|HEAD /fiscalYears/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        /** @var FiscalYear $fiscalYear */
        $fiscalYear = FiscalYear::find($id);

        if (empty($fiscalYear)) {
            return $this->sendError('Fiscal Year not found');
        }

        return $this->sendResponse($fiscalYear->toArray(), 'Fiscal Year retrieved successfully');
    }

    /**
     * Update the specified FiscalYear in storage.
     * PUT/PATCH /fiscalYears/{id}
     *
     * @param int $id
     * @param UpdateFiscalYearAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFiscalYearAPIRequest $request, Organization $organization)
    {
        /** @var FiscalYear $fiscalYear */
        $fiscalYear = FiscalYear::find($id);

        if (empty($fiscalYear)) {
            return $this->sendError('Fiscal Year not found');
        }

        $fiscalYear->fill($request->all());
        $fiscalYear->save();
        
        FiscalYearUpdated::dispatch($fiscalYear);
        return $this->sendResponse($fiscalYear->toArray(), 'FiscalYear updated successfully');
    }

    /**
     * Remove the specified FiscalYear from storage.
     * DELETE /fiscalYears/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Organization $organization)
    {
        /** @var FiscalYear $fiscalYear */
        $fiscalYear = FiscalYear::find($id);

        if (empty($fiscalYear)) {
            return $this->sendError('Fiscal Year not found');
        }

        $fiscalYear->delete();
        FiscalYearDeleted::dispatch($fiscalYear);
        return $this->sendSuccess('Fiscal Year deleted successfully');
    }
}
