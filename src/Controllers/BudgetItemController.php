<?php

namespace Hasob\FoundationCore\Controllers;

use Hasob\FoundationCore\Models\BudgetItem;

use Hasob\FoundationCore\Events\BudgetItemCreated;
use Hasob\FoundationCore\Events\BudgetItemUpdated;
use Hasob\FoundationCore\Events\BudgetItemDeleted;

use Hasob\FoundationCore\Requests\CreateBudgetItemRequest;
use Hasob\FoundationCore\Requests\UpdateBudgetItemRequest;

use Hasob\FoundationCore\DataTables\BudgetItemDataTable;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;

use Flash;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class BudgetItemController extends BaseController
{
    /**
     * Display a listing of the BudgetItem.
     *
     * @param BudgetItemDataTable $budgetItemDataTable
     * @return Response
     */
    public function index(Organization $org, BudgetItemDataTable $budgetItemDataTable)
    {
        $current_user = Auth()->user();

        $cdv_budget_items = new \Hasob\FoundationCore\View\Components\CardDataView(BudgetItem::class, "hasob-lab-manager-module::pages.budget_items.card_view_item");
        $cdv_budget_items->setDataQuery(['organization_id'=>$org->id])
                        //->addDataGroup('label','field','value')
                        //->setSearchFields(['field_to_search1','field_to_search2'])
                        //->addDataOrder('display_ordinal','DESC')
                        //->addDataOrder('id','DESC')
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(20)
                        ->setSearchPlaceholder('Search BudgetItem');

        if (request()->expectsJson()){
            return $cdv_budget_items->render();
        }

        return view('hasob-lab-manager-module::pages.budget_items.card_view_index')
                    ->with('current_user', $current_user)
                    ->with('months_list', BaseController::monthsList())
                    ->with('states_list', BaseController::statesList())
                    ->with('cdv_budget_items', $cdv_budget_items);

        /*
        return $budgetItemDataTable->render('hasob-lab-manager-module::pages.budget_items.index',[
            'current_user'=>$current_user,
            'months_list'=>BaseController::monthsList(),
            'states_list'=>BaseController::statesList()
        ]);
        */
    }

    /**
     * Show the form for creating a new BudgetItem.
     *
     * @return Response
     */
    public function create(Organization $org)
    {
        return view('hasob-lab-manager-module::pages.budget_items.create');
    }

    /**
     * Store a newly created BudgetItem in storage.
     *
     * @param CreateBudgetItemRequest $request
     *
     * @return Response
     */
    public function store(Organization $org, CreateBudgetItemRequest $request)
    {
        $input = $request->all();

        /** @var BudgetItem $budgetItem */
        $budgetItem = BudgetItem::create($input);

        //Flash::success('Budget Item saved successfully.');

        BudgetItemCreated::dispatch($budgetItem);
        return redirect(route('lm.budgetItems.index'));
    }

    /**
     * Display the specified BudgetItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(Organization $org, $id)
    {
        /** @var BudgetItem $budgetItem */
        $budgetItem = BudgetItem::find($id);

        if (empty($budgetItem)) {
            //Flash::error('Budget Item not found');

            return redirect(route('lm.budgetItems.index'));
        }

        return view('hasob-lab-manager-module::pages.budget_items.show')->with('budgetItem', $budgetItem);
    }

    /**
     * Show the form for editing the specified BudgetItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Organization $org, $id)
    {
        /** @var BudgetItem $budgetItem */
        $budgetItem = BudgetItem::find($id);

        if (empty($budgetItem)) {
            //Flash::error('Budget Item not found');

            return redirect(route('lm.budgetItems.index'));
        }

        return view('hasob-lab-manager-module::pages.budget_items.edit')->with('budgetItem', $budgetItem);
    }

    /**
     * Update the specified BudgetItem in storage.
     *
     * @param  int              $id
     * @param UpdateBudgetItemRequest $request
     *
     * @return Response
     */
    public function update(Organization $org, $id, UpdateBudgetItemRequest $request)
    {
        /** @var BudgetItem $budgetItem */
        $budgetItem = BudgetItem::find($id);

        if (empty($budgetItem)) {
            //Flash::error('Budget Item not found');

            return redirect(route('lm.budgetItems.index'));
        }

        $budgetItem->fill($request->all());
        $budgetItem->save();

        //Flash::success('Budget Item updated successfully.');
        
        BudgetItemUpdated::dispatch($budgetItem);
        return redirect(route('lm.budgetItems.index'));
    }

    /**
     * Remove the specified BudgetItem from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Organization $org, $id)
    {
        /** @var BudgetItem $budgetItem */
        $budgetItem = BudgetItem::find($id);

        if (empty($budgetItem)) {
            //Flash::error('Budget Item not found');

            return redirect(route('lm.budgetItems.index'));
        }

        $budgetItem->delete();

        //Flash::success('Budget Item deleted successfully.');
        BudgetItemDeleted::dispatch($budgetItem);
        return redirect(route('lm.budgetItems.index'));
    }

        
    public function processBulkUpload(Organization $org, Request $request){

        $attachedFileName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('uploads'), $attachedFileName);
        $path_to_file = public_path('uploads').'/'.$attachedFileName;

        //Process each line
        $loop = 1;
        $errors = [];
        $lines = file($path_to_file);

        if (count($lines) > 1) {
            foreach ($lines as $line) {
                
                if ($loop > 1) {
                    $data = explode(',', $line);
                    // if (count($invalids) > 0) {
                    //     array_push($errors, $invalids);
                    //     continue;
                    // }else{
                    //     //Check if line is valid
                    //     if (!$valid) {
                    //         $errors[] = $msg;
                    //     }
                    // }
                }
                $loop++;
            }
        }else{
            $errors[] = 'The uploaded csv file is empty';
        }
        
        if (count($errors) > 0) {
            return $this->sendError($this->array_flatten($errors), 'Errors processing file');
        }
        return $this->sendResponse($subject->toArray(), 'Bulk upload completed successfully');
    }
}
