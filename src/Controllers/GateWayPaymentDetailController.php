<?php

namespace Hasob\FoundationCore\Controllers;

use Hasob\FoundationCore\Models\GateWayPaymentDetail;

use Hasob\FoundationCore\Events\GateWayPaymentDetailCreated;
use Hasob\FoundationCore\Events\GateWayPaymentDetailUpdated;
use Hasob\FoundationCore\Events\GateWayPaymentDetailDeleted;

use Hasob\FoundationCore\Requests\CreateGateWayPaymentDetailRequest;
use Hasob\FoundationCore\Requests\UpdateGateWayPaymentDetailRequest;

use Hasob\FoundationCore\DataTables\GateWayPaymentDetailDataTable;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;

use Flash;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class GateWayPaymentDetailController extends BaseController
{
    /**
     * Display a listing of the GateWayPaymentDetail.
     *
     * @param GateWayPaymentDetailDataTable $gateWayPaymentDetailDataTable
     * @return Response
     */
    public function index(Organization $org, GateWayPaymentDetailDataTable $gateWayPaymentDetailDataTable)
    {
        $current_user = Auth()->user();

        $cdv_gate_way_payment_details = new \Hasob\FoundationCore\View\Components\CardDataView(GateWayPaymentDetail::class, "hasob-foundationcore.gate_way_payment_details.card_view_item");
        $cdv_gate_way_payment_details->setDataQuery(['organization_id'=>$org->id])
                        //->addDataGroup('label','field','value')
                        //->setSearchFields(['field_to_search1','field_to_search2'])
                        //->addDataOrder('display_ordinal','DESC')
                        //->addDataOrder('id','DESC')
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(20)
                        ->setSearchPlaceholder('Search GateWayPaymentDetail');

        if (request()->expectsJson()){
            return $cdv_gate_way_payment_details->render();
        }

        return view('hasob-foundationcore.gate_way_payment_details.card_view_index')
                    ->with('current_user', $current_user)
                    ->with('months_list', BaseController::monthsList())
                    ->with('states_list', BaseController::statesList())
                    ->with('cdv_gate_way_payment_details', $cdv_gate_way_payment_details);

        /*
        return $gateWayPaymentDetailDataTable->render('hasob-foundationcore.gate_way_payment_details.index',[
            'current_user'=>$current_user,
            'months_list'=>BaseController::monthsList(),
            'states_list'=>BaseController::statesList()
        ]);
        */
    }

    /**
     * Show the form for creating a new GateWayPaymentDetail.
     *
     * @return Response
     */
    public function create(Organization $org)
    {
        return view('hasob-foundationcore.gate_way_payment_details.create');
    }

    /**
     * Store a newly created GateWayPaymentDetail in storage.
     *
     * @param CreateGateWayPaymentDetailRequest $request
     *
     * @return Response
     */
    public function store(Organization $org, CreateGateWayPaymentDetailRequest $request)
    {
        $input = $request->all();

        /** @var GateWayPaymentDetail $gateWayPaymentDetail */
        $gateWayPaymentDetail = GateWayPaymentDetail::create($input);

        GateWayPaymentDetailCreated::dispatch($gateWayPaymentDetail);
        return redirect(route('fc.gateWayPaymentDetails.index'));
    }

    /**
     * Display the specified GateWayPaymentDetail.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(Organization $org, $id)
    {
        $current_user = Auth()->user();

        /** @var GateWayPaymentDetail $gateWayPaymentDetail */
        $gateWayPaymentDetail = GateWayPaymentDetail::find($id);

        if (empty($gateWayPaymentDetail)) {
            return redirect(route('fc.gateWayPaymentDetails.index'));
        }

        return view('hasob-foundationcore.gate_way_payment_details.show')
                            ->with('gateWayPaymentDetail', $gateWayPaymentDetail)
                            ->with('current_user', $current_user)
                            ->with('months_list', BaseController::monthsList())
                            ->with('states_list', BaseController::statesList());
    }

    /**
     * Show the form for editing the specified GateWayPaymentDetail.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Organization $org, $id)
    {
        $current_user = Auth()->user();

        /** @var GateWayPaymentDetail $gateWayPaymentDetail */
        $gateWayPaymentDetail = GateWayPaymentDetail::find($id);

        if (empty($gateWayPaymentDetail)) {
            return redirect(route('fc.gateWayPaymentDetails.index'));
        }

        return view('hasob-foundationcore.gate_way_payment_details.edit')
                            ->with('gateWayPaymentDetail', $gateWayPaymentDetail)
                            ->with('current_user', $current_user)
                            ->with('months_list', BaseController::monthsList())
                            ->with('states_list', BaseController::statesList());
    }

    /**
     * Update the specified GateWayPaymentDetail in storage.
     *
     * @param  int              $id
     * @param UpdateGateWayPaymentDetailRequest $request
     *
     * @return Response
     */
    public function update(Organization $org, $id, UpdateGateWayPaymentDetailRequest $request)
    {
        /** @var GateWayPaymentDetail $gateWayPaymentDetail */
        $gateWayPaymentDetail = GateWayPaymentDetail::find($id);

        if (empty($gateWayPaymentDetail)) {
            return redirect(route('fc.gateWayPaymentDetails.index'));
        }

        $gateWayPaymentDetail->fill($request->all());
        $gateWayPaymentDetail->save();
        
        GateWayPaymentDetailUpdated::dispatch($gateWayPaymentDetail);
        return redirect(route('fc.gateWayPaymentDetails.index'));
    }

    /**
     * Remove the specified GateWayPaymentDetail from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Organization $org, $id)
    {
        /** @var GateWayPaymentDetail $gateWayPaymentDetail */
        $gateWayPaymentDetail = GateWayPaymentDetail::find($id);

        if (empty($gateWayPaymentDetail)) {
            return redirect(route('fc.gateWayPaymentDetails.index'));
        }

        $gateWayPaymentDetail->delete();

        GateWayPaymentDetailDeleted::dispatch($gateWayPaymentDetail);
        return redirect(route('fc.gateWayPaymentDetails.index'));
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
