<?php

namespace Hasob\FoundationCore\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hasob\FoundationCore\Models\BudgetItem;

use Hasob\FoundationCore\Events\BudgetItemCreated;
use Hasob\FoundationCore\Events\BudgetItemUpdated;
use Hasob\FoundationCore\Events\BudgetItemDeleted;

use Hasob\FoundationCore\Requests\API\CreateBudgetItemAPIRequest;
use Hasob\FoundationCore\Requests\API\UpdateBudgetItemAPIRequest;

use Hasob\FoundationCore\Traits\ApiResponder;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;

/**
 * Class BudgetItemController
 * @package Hasob\FoundationCore\Controllers\API
 */

class BudgetItemAPIController extends AppBaseController
{

    use ApiResponder;

    /**
     * Display a listing of the BudgetItem.
     * GET|HEAD /budgetItems
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = BudgetItem::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        
        if ($organization != null){
            $query->where('organization_id', $organization->id);
        }

        $budgetItems = $this->showAll($query->get());

        return $this->sendResponse($budgetItems->toArray(), 'Budget Items retrieved successfully');
    }

    /**
     * Store a newly created BudgetItem in storage.
     * POST /budgetItems
     *
     * @param CreateBudgetItemAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateBudgetItemAPIRequest $request, Organization $organization)
    {
        $input = $request->all();

        /** @var BudgetItem $budgetItem */
        $budgetItem = BudgetItem::create($input);
        
        BudgetItemCreated::dispatch($budgetItem);
        return $this->sendResponse($budgetItem->toArray(), 'Budget Item saved successfully');
    }

    /**
     * Display the specified BudgetItem.
     * GET|HEAD /budgetItems/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        /** @var BudgetItem $budgetItem */
        $budgetItem = BudgetItem::find($id);

        if (empty($budgetItem)) {
            return $this->sendError('Budget Item not found');
        }

        return $this->sendResponse($budgetItem->toArray(), 'Budget Item retrieved successfully');
    }

    /**
     * Update the specified BudgetItem in storage.
     * PUT/PATCH /budgetItems/{id}
     *
     * @param int $id
     * @param UpdateBudgetItemAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBudgetItemAPIRequest $request, Organization $organization)
    {
        /** @var BudgetItem $budgetItem */
        $budgetItem = BudgetItem::find($id);

        if (empty($budgetItem)) {
            return $this->sendError('Budget Item not found');
        }

        $budgetItem->fill($request->all());
        $budgetItem->save();
        
        BudgetItemUpdated::dispatch($budgetItem);
        return $this->sendResponse($budgetItem->toArray(), 'BudgetItem updated successfully');
    }

    /**
     * Remove the specified BudgetItem from storage.
     * DELETE /budgetItems/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Organization $organization)
    {
        /** @var BudgetItem $budgetItem */
        $budgetItem = BudgetItem::find($id);

        if (empty($budgetItem)) {
            return $this->sendError('Budget Item not found');
        }

        $budgetItem->delete();
        BudgetItemDeleted::dispatch($budgetItem);
        return $this->sendSuccess('Budget Item deleted successfully');
    }
}
