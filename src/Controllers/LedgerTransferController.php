<?php

namespace Hasob\FoundationCore\Controllers;

use Hasob\FoundationCore\Models\LedgerTransfer;

use Hasob\FoundationCore\Events\LedgerTransferCreated;
use Hasob\FoundationCore\Events\LedgerTransferUpdated;
use Hasob\FoundationCore\Events\LedgerTransferDeleted;

use Hasob\FoundationCore\Requests\CreateLedgerTransferRequest;
use Hasob\FoundationCore\Requests\UpdateLedgerTransferRequest;

use Hasob\FoundationCore\DataTables\LedgerTransferDataTable;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;

use Flash;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class LedgerTransferController extends BaseController
{
    /**
     * Display a listing of the LedgerTransfer.
     *
     * @param LedgerTransferDataTable $ledgerTransferDataTable
     * @return Response
     */
    public function index(Organization $org, LedgerTransferDataTable $ledgerTransferDataTable)
    {
        $current_user = Auth()->user();

        $cdv_ledger_transfers = new \Hasob\FoundationCore\View\Components\CardDataView(LedgerTransfer::class, "hasob-lab-manager-module::pages.ledger_transfers.card_view_item");
        $cdv_ledger_transfers->setDataQuery(['organization_id'=>$org->id])
                        //->addDataGroup('label','field','value')
                        //->setSearchFields(['field_to_search1','field_to_search2'])
                        //->addDataOrder('display_ordinal','DESC')
                        //->addDataOrder('id','DESC')
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(20)
                        ->setSearchPlaceholder('Search LedgerTransfer');

        if (request()->expectsJson()){
            return $cdv_ledger_transfers->render();
        }

        return view('hasob-lab-manager-module::pages.ledger_transfers.card_view_index')
                    ->with('current_user', $current_user)
                    ->with('months_list', BaseController::monthsList())
                    ->with('states_list', BaseController::statesList())
                    ->with('cdv_ledger_transfers', $cdv_ledger_transfers);

        /*
        return $ledgerTransferDataTable->render('hasob-lab-manager-module::pages.ledger_transfers.index',[
            'current_user'=>$current_user,
            'months_list'=>BaseController::monthsList(),
            'states_list'=>BaseController::statesList()
        ]);
        */
    }

    /**
     * Show the form for creating a new LedgerTransfer.
     *
     * @return Response
     */
    public function create(Organization $org)
    {
        return view('hasob-lab-manager-module::pages.ledger_transfers.create');
    }

    /**
     * Store a newly created LedgerTransfer in storage.
     *
     * @param CreateLedgerTransferRequest $request
     *
     * @return Response
     */
    public function store(Organization $org, CreateLedgerTransferRequest $request)
    {
        $input = $request->all();

        /** @var LedgerTransfer $ledgerTransfer */
        $ledgerTransfer = LedgerTransfer::create($input);

        //Flash::success('Ledger Transfer saved successfully.');

        LedgerTransferCreated::dispatch($ledgerTransfer);
        return redirect(route('lm.ledgerTransfers.index'));
    }

    /**
     * Display the specified LedgerTransfer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(Organization $org, $id)
    {
        /** @var LedgerTransfer $ledgerTransfer */
        $ledgerTransfer = LedgerTransfer::find($id);

        if (empty($ledgerTransfer)) {
            //Flash::error('Ledger Transfer not found');

            return redirect(route('lm.ledgerTransfers.index'));
        }

        return view('hasob-lab-manager-module::pages.ledger_transfers.show')->with('ledgerTransfer', $ledgerTransfer);
    }

    /**
     * Show the form for editing the specified LedgerTransfer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Organization $org, $id)
    {
        /** @var LedgerTransfer $ledgerTransfer */
        $ledgerTransfer = LedgerTransfer::find($id);

        if (empty($ledgerTransfer)) {
            //Flash::error('Ledger Transfer not found');

            return redirect(route('lm.ledgerTransfers.index'));
        }

        return view('hasob-lab-manager-module::pages.ledger_transfers.edit')->with('ledgerTransfer', $ledgerTransfer);
    }

    /**
     * Update the specified LedgerTransfer in storage.
     *
     * @param  int              $id
     * @param UpdateLedgerTransferRequest $request
     *
     * @return Response
     */
    public function update(Organization $org, $id, UpdateLedgerTransferRequest $request)
    {
        /** @var LedgerTransfer $ledgerTransfer */
        $ledgerTransfer = LedgerTransfer::find($id);

        if (empty($ledgerTransfer)) {
            //Flash::error('Ledger Transfer not found');

            return redirect(route('lm.ledgerTransfers.index'));
        }

        $ledgerTransfer->fill($request->all());
        $ledgerTransfer->save();

        //Flash::success('Ledger Transfer updated successfully.');
        
        LedgerTransferUpdated::dispatch($ledgerTransfer);
        return redirect(route('lm.ledgerTransfers.index'));
    }

    /**
     * Remove the specified LedgerTransfer from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Organization $org, $id)
    {
        /** @var LedgerTransfer $ledgerTransfer */
        $ledgerTransfer = LedgerTransfer::find($id);

        if (empty($ledgerTransfer)) {
            //Flash::error('Ledger Transfer not found');

            return redirect(route('lm.ledgerTransfers.index'));
        }

        $ledgerTransfer->delete();

        //Flash::success('Ledger Transfer deleted successfully.');
        LedgerTransferDeleted::dispatch($ledgerTransfer);
        return redirect(route('lm.ledgerTransfers.index'));
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
