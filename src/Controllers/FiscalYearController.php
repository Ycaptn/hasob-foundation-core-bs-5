<?php

namespace Hasob\FoundationCore\Controllers;

use Hasob\FoundationCore\Models\FiscalYear;

use Hasob\FoundationCore\Events\FiscalYearCreated;
use Hasob\FoundationCore\Events\FiscalYearUpdated;
use Hasob\FoundationCore\Events\FiscalYearDeleted;

use Hasob\FoundationCore\Requests\CreateFiscalYearRequest;
use Hasob\FoundationCore\Requests\UpdateFiscalYearRequest;

use Hasob\FoundationCore\DataTables\FiscalYearDataTable;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;

use Flash;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class FiscalYearController extends BaseController
{
    /**
     * Display a listing of the FiscalYear.
     *
     * @param FiscalYearDataTable $fiscalYearDataTable
     * @return Response
     */
    public function index(Organization $org, FiscalYearDataTable $fiscalYearDataTable)
    {
        $current_user = Auth()->user();

        $cdv_fiscal_years = new \Hasob\FoundationCore\View\Components\CardDataView(FiscalYear::class, "hasob-lab-manager-module::pages.fiscal_years.card_view_item");
        $cdv_fiscal_years->setDataQuery(['organization_id'=>$org->id])
                        //->addDataGroup('label','field','value')
                        //->setSearchFields(['field_to_search1','field_to_search2'])
                        //->addDataOrder('display_ordinal','DESC')
                        //->addDataOrder('id','DESC')
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(20)
                        ->setSearchPlaceholder('Search FiscalYear');

        if (request()->expectsJson()){
            return $cdv_fiscal_years->render();
        }

        return view('hasob-lab-manager-module::pages.fiscal_years.card_view_index')
                    ->with('current_user', $current_user)
                    ->with('months_list', BaseController::monthsList())
                    ->with('states_list', BaseController::statesList())
                    ->with('cdv_fiscal_years', $cdv_fiscal_years);

        /*
        return $fiscalYearDataTable->render('hasob-lab-manager-module::pages.fiscal_years.index',[
            'current_user'=>$current_user,
            'months_list'=>BaseController::monthsList(),
            'states_list'=>BaseController::statesList()
        ]);
        */
    }

    /**
     * Show the form for creating a new FiscalYear.
     *
     * @return Response
     */
    public function create(Organization $org)
    {
        return view('hasob-lab-manager-module::pages.fiscal_years.create');
    }

    /**
     * Store a newly created FiscalYear in storage.
     *
     * @param CreateFiscalYearRequest $request
     *
     * @return Response
     */
    public function store(Organization $org, CreateFiscalYearRequest $request)
    {
        $input = $request->all();

        /** @var FiscalYear $fiscalYear */
        $fiscalYear = FiscalYear::create($input);

        //Flash::success('Fiscal Year saved successfully.');

        FiscalYearCreated::dispatch($fiscalYear);
        return redirect(route('lm.fiscalYears.index'));
    }

    /**
     * Display the specified FiscalYear.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(Organization $org, $id)
    {
        /** @var FiscalYear $fiscalYear */
        $fiscalYear = FiscalYear::find($id);

        if (empty($fiscalYear)) {
            //Flash::error('Fiscal Year not found');

            return redirect(route('lm.fiscalYears.index'));
        }

        return view('hasob-lab-manager-module::pages.fiscal_years.show')->with('fiscalYear', $fiscalYear);
    }

    /**
     * Show the form for editing the specified FiscalYear.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Organization $org, $id)
    {
        /** @var FiscalYear $fiscalYear */
        $fiscalYear = FiscalYear::find($id);

        if (empty($fiscalYear)) {
            //Flash::error('Fiscal Year not found');

            return redirect(route('lm.fiscalYears.index'));
        }

        return view('hasob-lab-manager-module::pages.fiscal_years.edit')->with('fiscalYear', $fiscalYear);
    }

    /**
     * Update the specified FiscalYear in storage.
     *
     * @param  int              $id
     * @param UpdateFiscalYearRequest $request
     *
     * @return Response
     */
    public function update(Organization $org, $id, UpdateFiscalYearRequest $request)
    {
        /** @var FiscalYear $fiscalYear */
        $fiscalYear = FiscalYear::find($id);

        if (empty($fiscalYear)) {
            //Flash::error('Fiscal Year not found');

            return redirect(route('lm.fiscalYears.index'));
        }

        $fiscalYear->fill($request->all());
        $fiscalYear->save();

        //Flash::success('Fiscal Year updated successfully.');
        
        FiscalYearUpdated::dispatch($fiscalYear);
        return redirect(route('lm.fiscalYears.index'));
    }

    /**
     * Remove the specified FiscalYear from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Organization $org, $id)
    {
        /** @var FiscalYear $fiscalYear */
        $fiscalYear = FiscalYear::find($id);

        if (empty($fiscalYear)) {
            //Flash::error('Fiscal Year not found');

            return redirect(route('lm.fiscalYears.index'));
        }

        $fiscalYear->delete();

        //Flash::success('Fiscal Year deleted successfully.');
        FiscalYearDeleted::dispatch($fiscalYear);
        return redirect(route('lm.fiscalYears.index'));
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
