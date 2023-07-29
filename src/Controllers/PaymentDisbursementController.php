<?php

namespace Hasob\FoundationCore\Controllers;

use Hasob\FoundatioCore\Models\PaymentDisbursement;

use Hasob\FoundatioCore\Events\PaymentDisbursementCreated;
use Hasob\FoundatioCore\Events\PaymentDisbursementUpdated;
use Hasob\FoundatioCore\Events\PaymentDisbursementDeleted;

use Hasob\FoundatioCore\Requests\CreatePaymentDisbursementRequest;
use Hasob\FoundatioCore\Requests\UpdatePaymentDisbursementRequest;

use Hasob\FoundatioCore\DataTables\PaymentDisbursementDataTable;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;

use Flash;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class PaymentDisbursementController extends BaseController
{
    /**
     * Display a listing of the PaymentDisbursement.
     *
     * @param PaymentDisbursementDataTable $paymentDisbursementDataTable
     * @return Response
     */
    public function index(Organization $org, PaymentDisbursementDataTable $paymentDisbursementDataTable)
    {
        $current_user = Auth()->user();

        $cdv_payment_disbursements = new \Hasob\FoundationCore\View\Components\CardDataView(PaymentDisbursement::class, "hasob-foundation-core::payment_disbursements.card_view_item");
        $cdv_payment_disbursements->setDataQuery(['organization_id'=>$org->id])
                        //->addDataGroup('label','field','value')
                        //->setSearchFields(['field_to_search1','field_to_search2'])
                        //->addDataOrder('display_ordinal','DESC')
                        //->addDataOrder('id','DESC')
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(20)
                        ->setSearchPlaceholder('Search PaymentDisbursement');

        if (request()->expectsJson()){
            return $cdv_payment_disbursements->render();
        }

        return view('hasob-foundation-core::payment_disbursements.card_view_index')
                    ->with('current_user', $current_user)
                    ->with('months_list', BaseController::monthsList())
                    ->with('states_list', BaseController::statesList())
                    ->with('cdv_payment_disbursements', $cdv_payment_disbursements);

        /*
        return $paymentDisbursementDataTable->render('hasob-foundation-core::payment_disbursements.index',[
            'current_user'=>$current_user,
            'months_list'=>BaseController::monthsList(),
            'states_list'=>BaseController::statesList()
        ]);
        */
    }

    /**
     * Show the form for creating a new PaymentDisbursement.
     *
     * @return Response
     */
    public function create(Organization $org)
    {
        return view('hasob-foundation-core::payment_disbursements.create');
    }

    /**
     * Store a newly created PaymentDisbursement in storage.
     *
     * @param CreatePaymentDisbursementRequest $request
     *
     * @return Response
     */
    public function store(Organization $org, CreatePaymentDisbursementRequest $request)
    {
        $input = $request->all();

        /** @var PaymentDisbursement $paymentDisbursement */
        $paymentDisbursement = PaymentDisbursement::create($input);

        PaymentDisbursementCreated::dispatch($paymentDisbursement);
        return redirect(route('fc.paymentDisbursements.index'));
    }

    /**
     * Display the specified PaymentDisbursement.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(Organization $org, $id)
    {
        $current_user = Auth()->user();

        /** @var PaymentDisbursement $paymentDisbursement */
        $paymentDisbursement = PaymentDisbursement::find($id);

        if (empty($paymentDisbursement)) {
            return redirect(route('fc.paymentDisbursements.index'));
        }

        return view('hasob-foundation-core::payment_disbursements.show')
                            ->with('paymentDisbursement', $paymentDisbursement)
                            ->with('current_user', $current_user)
                            ->with('months_list', BaseController::monthsList())
                            ->with('states_list', BaseController::statesList());
    }

    /**
     * Show the form for editing the specified PaymentDisbursement.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Organization $org, $id)
    {
        $current_user = Auth()->user();

        /** @var PaymentDisbursement $paymentDisbursement */
        $paymentDisbursement = PaymentDisbursement::find($id);

        if (empty($paymentDisbursement)) {
            return redirect(route('fc.paymentDisbursements.index'));
        }

        return view('hasob-foundation-core::payment_disbursements.edit')
                            ->with('paymentDisbursement', $paymentDisbursement)
                            ->with('current_user', $current_user)
                            ->with('months_list', BaseController::monthsList())
                            ->with('states_list', BaseController::statesList());
    }

    /**
     * Update the specified PaymentDisbursement in storage.
     *
     * @param  int              $id
     * @param UpdatePaymentDisbursementRequest $request
     *
     * @return Response
     */
    public function update(Organization $org, $id, UpdatePaymentDisbursementRequest $request)
    {
        /** @var PaymentDisbursement $paymentDisbursement */
        $paymentDisbursement = PaymentDisbursement::find($id);

        if (empty($paymentDisbursement)) {
            return redirect(route('fc.paymentDisbursements.index'));
        }

        $paymentDisbursement->fill($request->all());
        $paymentDisbursement->save();
        
        PaymentDisbursementUpdated::dispatch($paymentDisbursement);
        return redirect(route('fc.paymentDisbursements.index'));
    }

    /**
     * Remove the specified PaymentDisbursement from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Organization $org, $id)
    {
        /** @var PaymentDisbursement $paymentDisbursement */
        $paymentDisbursement = PaymentDisbursement::find($id);

        if (empty($paymentDisbursement)) {
            return redirect(route('fc.paymentDisbursements.index'));
        }

        $paymentDisbursement->delete();

        PaymentDisbursementDeleted::dispatch($paymentDisbursement);
        return redirect(route('fc.paymentDisbursements.index'));
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
