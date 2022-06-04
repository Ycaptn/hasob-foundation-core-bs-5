<?php

namespace Hasob\FoundationCore\Controllers;

use Hasob\FoundationCore\Models\Budget;

use Hasob\FoundationCore\Events\BudgetCreated;
use Hasob\FoundationCore\Events\BudgetUpdated;
use Hasob\FoundationCore\Events\BudgetDeleted;

use Hasob\FoundationCore\Requests\CreateBudgetRequest;
use Hasob\FoundationCore\Requests\UpdateBudgetRequest;

use Hasob\FoundationCore\DataTables\BudgetDataTable;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;

use Flash;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class BudgetController extends BaseController
{
    /**
     * Display a listing of the Budget.
     *
     * @param BudgetDataTable $budgetDataTable
     * @return Response
     */
    public function index(Organization $org, BudgetDataTable $budgetDataTable)
    {
        $current_user = Auth()->user();

        $cdv_budgets = new \Hasob\FoundationCore\View\Components\CardDataView(Budget::class, "hasob-lab-manager-module::pages.budgets.card_view_item");
        $cdv_budgets->setDataQuery(['organization_id'=>$org->id])
                        //->addDataGroup('label','field','value')
                        //->setSearchFields(['field_to_search1','field_to_search2'])
                        //->addDataOrder('display_ordinal','DESC')
                        //->addDataOrder('id','DESC')
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(20)
                        ->setSearchPlaceholder('Search Budget');

        if (request()->expectsJson()){
            return $cdv_budgets->render();
        }

        return view('hasob-lab-manager-module::pages.budgets.card_view_index')
                    ->with('current_user', $current_user)
                    ->with('months_list', BaseController::monthsList())
                    ->with('states_list', BaseController::statesList())
                    ->with('cdv_budgets', $cdv_budgets);

        /*
        return $budgetDataTable->render('hasob-lab-manager-module::pages.budgets.index',[
            'current_user'=>$current_user,
            'months_list'=>BaseController::monthsList(),
            'states_list'=>BaseController::statesList()
        ]);
        */
    }

    /**
     * Show the form for creating a new Budget.
     *
     * @return Response
     */
    public function create(Organization $org)
    {
        return view('hasob-lab-manager-module::pages.budgets.create');
    }

    /**
     * Store a newly created Budget in storage.
     *
     * @param CreateBudgetRequest $request
     *
     * @return Response
     */
    public function store(Organization $org, CreateBudgetRequest $request)
    {
        $input = $request->all();

        /** @var Budget $budget */
        $budget = Budget::create($input);

        //Flash::success('Budget saved successfully.');

        BudgetCreated::dispatch($budget);
        return redirect(route('lm.budgets.index'));
    }

    /**
     * Display the specified Budget.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(Organization $org, $id)
    {
        /** @var Budget $budget */
        $budget = Budget::find($id);

        if (empty($budget)) {
            //Flash::error('Budget not found');

            return redirect(route('lm.budgets.index'));
        }

        return view('hasob-lab-manager-module::pages.budgets.show')->with('budget', $budget);
    }

    /**
     * Show the form for editing the specified Budget.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Organization $org, $id)
    {
        /** @var Budget $budget */
        $budget = Budget::find($id);

        if (empty($budget)) {
            //Flash::error('Budget not found');

            return redirect(route('lm.budgets.index'));
        }

        return view('hasob-lab-manager-module::pages.budgets.edit')->with('budget', $budget);
    }

    /**
     * Update the specified Budget in storage.
     *
     * @param  int              $id
     * @param UpdateBudgetRequest $request
     *
     * @return Response
     */
    public function update(Organization $org, $id, UpdateBudgetRequest $request)
    {
        /** @var Budget $budget */
        $budget = Budget::find($id);

        if (empty($budget)) {
            //Flash::error('Budget not found');

            return redirect(route('lm.budgets.index'));
        }

        $budget->fill($request->all());
        $budget->save();

        //Flash::success('Budget updated successfully.');
        
        BudgetUpdated::dispatch($budget);
        return redirect(route('lm.budgets.index'));
    }

    /**
     * Remove the specified Budget from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Organization $org, $id)
    {
        /** @var Budget $budget */
        $budget = Budget::find($id);

        if (empty($budget)) {
            //Flash::error('Budget not found');

            return redirect(route('lm.budgets.index'));
        }

        $budget->delete();

        //Flash::success('Budget deleted successfully.');
        BudgetDeleted::dispatch($budget);
        return redirect(route('lm.budgets.index'));
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
