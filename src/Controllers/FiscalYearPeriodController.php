<?php

namespace Hasob\FoundationCore\Controllers;

use Hasob\FoundationCore\Models\FiscalYearPeriod;

use Hasob\FoundationCore\Events\FiscalYearPeriodCreated;
use Hasob\FoundationCore\Events\FiscalYearPeriodUpdated;
use Hasob\FoundationCore\Events\FiscalYearPeriodDeleted;

use Hasob\FoundationCore\Requests\CreateFiscalYearPeriodRequest;
use Hasob\FoundationCore\Requests\UpdateFiscalYearPeriodRequest;

use Hasob\FoundationCore\DataTables\FiscalYearPeriodDataTable;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;

use Flash;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class FiscalYearPeriodController extends BaseController
{
    /**
     * Display a listing of the FiscalYearPeriod.
     *
     * @param FiscalYearPeriodDataTable $fiscalYearPeriodDataTable
     * @return Response
     */
    public function index(Organization $org, FiscalYearPeriodDataTable $fiscalYearPeriodDataTable)
    {
        $current_user = Auth()->user();

        $cdv_fiscal_year_periods = new \Hasob\FoundationCore\View\Components\CardDataView(FiscalYearPeriod::class, "hasob-lab-manager-module::pages.fiscal_year_periods.card_view_item");
        $cdv_fiscal_year_periods->setDataQuery(['organization_id'=>$org->id])
                        //->addDataGroup('label','field','value')
                        //->setSearchFields(['field_to_search1','field_to_search2'])
                        //->addDataOrder('display_ordinal','DESC')
                        //->addDataOrder('id','DESC')
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(20)
                        ->setSearchPlaceholder('Search FiscalYearPeriod');

        if (request()->expectsJson()){
            return $cdv_fiscal_year_periods->render();
        }

        return view('hasob-lab-manager-module::pages.fiscal_year_periods.card_view_index')
                    ->with('current_user', $current_user)
                    ->with('months_list', BaseController::monthsList())
                    ->with('states_list', BaseController::statesList())
                    ->with('cdv_fiscal_year_periods', $cdv_fiscal_year_periods);

        /*
        return $fiscalYearPeriodDataTable->render('hasob-lab-manager-module::pages.fiscal_year_periods.index',[
            'current_user'=>$current_user,
            'months_list'=>BaseController::monthsList(),
            'states_list'=>BaseController::statesList()
        ]);
        */
    }

    /**
     * Show the form for creating a new FiscalYearPeriod.
     *
     * @return Response
     */
    public function create(Organization $org)
    {
        return view('hasob-lab-manager-module::pages.fiscal_year_periods.create');
    }

    /**
     * Store a newly created FiscalYearPeriod in storage.
     *
     * @param CreateFiscalYearPeriodRequest $request
     *
     * @return Response
     */
    public function store(Organization $org, CreateFiscalYearPeriodRequest $request)
    {
        $input = $request->all();

        /** @var FiscalYearPeriod $fiscalYearPeriod */
        $fiscalYearPeriod = FiscalYearPeriod::create($input);

        //Flash::success('Fiscal Year Period saved successfully.');

        FiscalYearPeriodCreated::dispatch($fiscalYearPeriod);
        return redirect(route('lm.fiscalYearPeriods.index'));
    }

    /**
     * Display the specified FiscalYearPeriod.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(Organization $org, $id)
    {
        /** @var FiscalYearPeriod $fiscalYearPeriod */
        $fiscalYearPeriod = FiscalYearPeriod::find($id);

        if (empty($fiscalYearPeriod)) {
            //Flash::error('Fiscal Year Period not found');

            return redirect(route('lm.fiscalYearPeriods.index'));
        }

        return view('hasob-lab-manager-module::pages.fiscal_year_periods.show')->with('fiscalYearPeriod', $fiscalYearPeriod);
    }

    /**
     * Show the form for editing the specified FiscalYearPeriod.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Organization $org, $id)
    {
        /** @var FiscalYearPeriod $fiscalYearPeriod */
        $fiscalYearPeriod = FiscalYearPeriod::find($id);

        if (empty($fiscalYearPeriod)) {
            //Flash::error('Fiscal Year Period not found');

            return redirect(route('lm.fiscalYearPeriods.index'));
        }

        return view('hasob-lab-manager-module::pages.fiscal_year_periods.edit')->with('fiscalYearPeriod', $fiscalYearPeriod);
    }

    /**
     * Update the specified FiscalYearPeriod in storage.
     *
     * @param  int              $id
     * @param UpdateFiscalYearPeriodRequest $request
     *
     * @return Response
     */
    public function update(Organization $org, $id, UpdateFiscalYearPeriodRequest $request)
    {
        /** @var FiscalYearPeriod $fiscalYearPeriod */
        $fiscalYearPeriod = FiscalYearPeriod::find($id);

        if (empty($fiscalYearPeriod)) {
            //Flash::error('Fiscal Year Period not found');

            return redirect(route('lm.fiscalYearPeriods.index'));
        }

        $fiscalYearPeriod->fill($request->all());
        $fiscalYearPeriod->save();

        //Flash::success('Fiscal Year Period updated successfully.');
        
        FiscalYearPeriodUpdated::dispatch($fiscalYearPeriod);
        return redirect(route('lm.fiscalYearPeriods.index'));
    }

    /**
     * Remove the specified FiscalYearPeriod from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Organization $org, $id)
    {
        /** @var FiscalYearPeriod $fiscalYearPeriod */
        $fiscalYearPeriod = FiscalYearPeriod::find($id);

        if (empty($fiscalYearPeriod)) {
            //Flash::error('Fiscal Year Period not found');

            return redirect(route('lm.fiscalYearPeriods.index'));
        }

        $fiscalYearPeriod->delete();

        //Flash::success('Fiscal Year Period deleted successfully.');
        FiscalYearPeriodDeleted::dispatch($fiscalYearPeriod);
        return redirect(route('lm.fiscalYearPeriods.index'));
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
