<?php

namespace Hasob\FoundationCore\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hasob\FoundationCore\Models\Budget;

use Hasob\FoundationCore\Events\BudgetCreated;
use Hasob\FoundationCore\Events\BudgetUpdated;
use Hasob\FoundationCore\Events\BudgetDeleted;

use Hasob\FoundationCore\Requests\API\CreateBudgetAPIRequest;
use Hasob\FoundationCore\Requests\API\UpdateBudgetAPIRequest;

use Hasob\FoundationCore\Traits\ApiResponder;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;

/**
 * Class BudgetController
 * @package Hasob\FoundationCore\Controllers\API
 */

class BudgetAPIController extends AppBaseController
{

    use ApiResponder;

    /**
     * Display a listing of the Budget.
     * GET|HEAD /budgets
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = Budget::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        
        if ($organization != null){
            $query->where('organization_id', $organization->id);
        }

        $budgets = $this->showAll($query->get());

        return $this->sendResponse($budgets->toArray(), 'Budgets retrieved successfully');
    }

    /**
     * Store a newly created Budget in storage.
     * POST /budgets
     *
     * @param CreateBudgetAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateBudgetAPIRequest $request, Organization $organization)
    {
        $input = $request->all();

        /** @var Budget $budget */
        $budget = Budget::create($input);
        
        BudgetCreated::dispatch($budget);
        return $this->sendResponse($budget->toArray(), 'Budget saved successfully');
    }

    /**
     * Display the specified Budget.
     * GET|HEAD /budgets/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        /** @var Budget $budget */
        $budget = Budget::find($id);

        if (empty($budget)) {
            return $this->sendError('Budget not found');
        }

        return $this->sendResponse($budget->toArray(), 'Budget retrieved successfully');
    }

    /**
     * Update the specified Budget in storage.
     * PUT/PATCH /budgets/{id}
     *
     * @param int $id
     * @param UpdateBudgetAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBudgetAPIRequest $request, Organization $organization)
    {
        /** @var Budget $budget */
        $budget = Budget::find($id);

        if (empty($budget)) {
            return $this->sendError('Budget not found');
        }

        $budget->fill($request->all());
        $budget->save();
        
        BudgetUpdated::dispatch($budget);
        return $this->sendResponse($budget->toArray(), 'Budget updated successfully');
    }

    /**
     * Remove the specified Budget from storage.
     * DELETE /budgets/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Organization $organization)
    {
        /** @var Budget $budget */
        $budget = Budget::find($id);

        if (empty($budget)) {
            return $this->sendError('Budget not found');
        }

        $budget->delete();
        BudgetDeleted::dispatch($budget);
        return $this->sendSuccess('Budget deleted successfully');
    }
}
