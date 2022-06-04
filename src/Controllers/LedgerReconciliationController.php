<?php

namespace Hasob\FoundationCore\Controllers;

use Hasob\FoundationCore\Models\LedgerReconciliation;

use Hasob\FoundationCore\Events\LedgerReconciliationCreated;
use Hasob\FoundationCore\Events\LedgerReconciliationUpdated;
use Hasob\FoundationCore\Events\LedgerReconciliationDeleted;

use Hasob\FoundationCore\Requests\CreateLedgerReconciliationRequest;
use Hasob\FoundationCore\Requests\UpdateLedgerReconciliationRequest;

use Hasob\FoundationCore\DataTables\LedgerReconciliationDataTable;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;

use Flash;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class LedgerReconciliationController extends BaseController
{
    /**
     * Display a listing of the LedgerReconciliation.
     *
     * @param LedgerReconciliationDataTable $ledgerReconciliationDataTable
     * @return Response
     */
    public function index(Organization $org, LedgerReconciliationDataTable $ledgerReconciliationDataTable)
    {
        $current_user = Auth()->user();

        $cdv_ledger_reconciliations = new \Hasob\FoundationCore\View\Components\CardDataView(LedgerReconciliation::class, "hasob-lab-manager-module::pages.ledger_reconciliations.card_view_item");
        $cdv_ledger_reconciliations->setDataQuery(['organization_id'=>$org->id])
                        //->addDataGroup('label','field','value')
                        //->setSearchFields(['field_to_search1','field_to_search2'])
                        //->addDataOrder('display_ordinal','DESC')
                        //->addDataOrder('id','DESC')
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(20)
                        ->setSearchPlaceholder('Search LedgerReconciliation');

        if (request()->expectsJson()){
            return $cdv_ledger_reconciliations->render();
        }

        return view('hasob-lab-manager-module::pages.ledger_reconciliations.card_view_index')
                    ->with('current_user', $current_user)
                    ->with('months_list', BaseController::monthsList())
                    ->with('states_list', BaseController::statesList())
                    ->with('cdv_ledger_reconciliations', $cdv_ledger_reconciliations);

        /*
        return $ledgerReconciliationDataTable->render('hasob-lab-manager-module::pages.ledger_reconciliations.index',[
            'current_user'=>$current_user,
            'months_list'=>BaseController::monthsList(),
            'states_list'=>BaseController::statesList()
        ]);
        */
    }

    /**
     * Show the form for creating a new LedgerReconciliation.
     *
     * @return Response
     */
    public function create(Organization $org)
    {
        return view('hasob-lab-manager-module::pages.ledger_reconciliations.create');
    }

    /**
     * Store a newly created LedgerReconciliation in storage.
     *
     * @param CreateLedgerReconciliationRequest $request
     *
     * @return Response
     */
    public function store(Organization $org, CreateLedgerReconciliationRequest $request)
    {
        $input = $request->all();

        /** @var LedgerReconciliation $ledgerReconciliation */
        $ledgerReconciliation = LedgerReconciliation::create($input);

        //Flash::success('Ledger Reconciliation saved successfully.');

        LedgerReconciliationCreated::dispatch($ledgerReconciliation);
        return redirect(route('lm.ledgerReconciliations.index'));
    }

    /**
     * Display the specified LedgerReconciliation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(Organization $org, $id)
    {
        /** @var LedgerReconciliation $ledgerReconciliation */
        $ledgerReconciliation = LedgerReconciliation::find($id);

        if (empty($ledgerReconciliation)) {
            //Flash::error('Ledger Reconciliation not found');

            return redirect(route('lm.ledgerReconciliations.index'));
        }

        return view('hasob-lab-manager-module::pages.ledger_reconciliations.show')->with('ledgerReconciliation', $ledgerReconciliation);
    }

    /**
     * Show the form for editing the specified LedgerReconciliation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Organization $org, $id)
    {
        /** @var LedgerReconciliation $ledgerReconciliation */
        $ledgerReconciliation = LedgerReconciliation::find($id);

        if (empty($ledgerReconciliation)) {
            //Flash::error('Ledger Reconciliation not found');

            return redirect(route('lm.ledgerReconciliations.index'));
        }

        return view('hasob-lab-manager-module::pages.ledger_reconciliations.edit')->with('ledgerReconciliation', $ledgerReconciliation);
    }

    /**
     * Update the specified LedgerReconciliation in storage.
     *
     * @param  int              $id
     * @param UpdateLedgerReconciliationRequest $request
     *
     * @return Response
     */
    public function update(Organization $org, $id, UpdateLedgerReconciliationRequest $request)
    {
        /** @var LedgerReconciliation $ledgerReconciliation */
        $ledgerReconciliation = LedgerReconciliation::find($id);

        if (empty($ledgerReconciliation)) {
            //Flash::error('Ledger Reconciliation not found');

            return redirect(route('lm.ledgerReconciliations.index'));
        }

        $ledgerReconciliation->fill($request->all());
        $ledgerReconciliation->save();

        //Flash::success('Ledger Reconciliation updated successfully.');
        
        LedgerReconciliationUpdated::dispatch($ledgerReconciliation);
        return redirect(route('lm.ledgerReconciliations.index'));
    }

    /**
     * Remove the specified LedgerReconciliation from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Organization $org, $id)
    {
        /** @var LedgerReconciliation $ledgerReconciliation */
        $ledgerReconciliation = LedgerReconciliation::find($id);

        if (empty($ledgerReconciliation)) {
            //Flash::error('Ledger Reconciliation not found');

            return redirect(route('lm.ledgerReconciliations.index'));
        }

        $ledgerReconciliation->delete();

        //Flash::success('Ledger Reconciliation deleted successfully.');
        LedgerReconciliationDeleted::dispatch($ledgerReconciliation);
        return redirect(route('lm.ledgerReconciliations.index'));
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
