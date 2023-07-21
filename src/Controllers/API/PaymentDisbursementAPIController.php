<?php

namespace Hasob\FoundationCore\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hasob\FoundationCore\Models\PaymentDisbursement;

use Hasob\FoundationCore\Events\PaymentDisbursementCreated;
use Hasob\FoundationCore\Events\PaymentDisbursementUpdated;
use Hasob\FoundationCore\Events\PaymentDisbursementDeleted;

use Hasob\FoundationCore\Requests\API\CreatePaymentDisbursementAPIRequest;
use Hasob\FoundationCore\Requests\API\UpdatePaymentDisbursementAPIRequest;

use Hasob\FoundationCore\Traits\ApiResponder;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;

/**
 * Class PaymentDisbursementController
 * @package Hasob\FoundationCore\Controllers\API
 */

class PaymentDisbursementAPIController extends AppBaseController
{

    use ApiResponder;

    /**
     * Display a listing of the PaymentDisbursement.
     * GET|HEAD /paymentDisbursements
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = PaymentDisbursement::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        
        if ($organization != null){
            $query->where('organization_id', $organization->id);
        }

        $paymentDisbursements = $this->showAll($query->get());

        return $this->sendResponse($paymentDisbursements->toArray(), 'Payment Disbursements retrieved successfully');
    }

    /**
     * Store a newly created PaymentDisbursement in storage.
     * POST /paymentDisbursements
     *
     * @param CreatePaymentDisbursementAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePaymentDisbursementAPIRequest $request, Organization $organization)
    {
        $input = $request->all();

        /** @var PaymentDisbursement $paymentDisbursement */
        $paymentDisbursement = PaymentDisbursement::create($input);
        
        PaymentDisbursementCreated::dispatch($paymentDisbursement);
        return $this->sendResponse($paymentDisbursement->toArray(), 'Payment Disbursement saved successfully');
    }

    /**
     * Display the specified PaymentDisbursement.
     * GET|HEAD /paymentDisbursements/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        /** @var PaymentDisbursement $paymentDisbursement */
        $paymentDisbursement = PaymentDisbursement::find($id);

        if (empty($paymentDisbursement)) {
            return $this->sendError('Payment Disbursement not found');
        }

        return $this->sendResponse($paymentDisbursement->toArray(), 'Payment Disbursement retrieved successfully');
    }

    /**
     * Update the specified PaymentDisbursement in storage.
     * PUT/PATCH /paymentDisbursements/{id}
     *
     * @param int $id
     * @param UpdatePaymentDisbursementAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePaymentDisbursementAPIRequest $request, Organization $organization)
    {
        /** @var PaymentDisbursement $paymentDisbursement */
        $paymentDisbursement = PaymentDisbursement::find($id);

        if (empty($paymentDisbursement)) {
            return $this->sendError('Payment Disbursement not found');
        }

        $paymentDisbursement->fill($request->all());
        $paymentDisbursement->save();
        
        PaymentDisbursementUpdated::dispatch($paymentDisbursement);
        return $this->sendResponse($paymentDisbursement->toArray(), 'PaymentDisbursement updated successfully');
    }

    /**
     * Remove the specified PaymentDisbursement from storage.
     * DELETE /paymentDisbursements/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Organization $organization)
    {
        /** @var PaymentDisbursement $paymentDisbursement */
        $paymentDisbursement = PaymentDisbursement::find($id);

        if (empty($paymentDisbursement)) {
            return $this->sendError('Payment Disbursement not found');
        }

        $paymentDisbursement->delete();
        PaymentDisbursementDeleted::dispatch($paymentDisbursement);
        return $this->sendSuccess('Payment Disbursement deleted successfully');
    }
}
