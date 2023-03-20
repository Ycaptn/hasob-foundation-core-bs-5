<?php

namespace Hasob\FoundationCore\Controllers\API;

use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;
use Hasob\FoundationCore\Events\BatchCreated;
use Hasob\FoundationCore\Events\BatchDeleted;
use Hasob\FoundationCore\Events\BatchUpdated;
use Hasob\FoundationCore\Models\Batch;
use Hasob\FoundationCore\Models\Organization;
use Hasob\FoundationCore\Requests\API\CreateBatchAPIRequest;
use Hasob\FoundationCore\Requests\API\CreateBatchItemAPIRequest;
use Hasob\FoundationCore\Requests\API\UpdateBatchAPIRequest;
use Hasob\FoundationCore\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class BatchController
 * @package Hasob\FoundationCore\Controllers\API
 */

class BatchAPIController extends AppBaseController
{

    use ApiResponder;

    /**
     * Display a listing of the Batch.
     * GET|HEAD /batches
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = Batch::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        if ($organization != null) {
            $query->where('organization_id', $organization->id);
        }

        $batches = $this->showAll($query->get());

        return $this->sendResponse($batches->toArray(), 'Batches retrieved successfully');
    }

    /**
     * Store a newly created Batch in storage.
     * POST /batches
     *
     * @param CreateBatchAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateBatchAPIRequest $request, Organization $organization)
    {
        $input = $request->all();

        /** @var Batch $batch */
        $batch = Batch::create($input);

        BatchCreated::dispatch($batch);
        return $this->sendResponse($batch->toArray(), 'Batch saved successfully');
    }

    /**
     * Display the specified Batch.
     * GET|HEAD /batches/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        /** @var Batch $batch */
        $batch = Batch::find($id);

        if (empty($batch)) {
            return $this->sendError('Batch not found');
        }

        return $this->sendResponse($batch->toArray(), 'Batch retrieved successfully');
    }

    /**
     * Update the specified Batch in storage.
     * PUT/PATCH /batches/{id}
     *
     * @param int $id
     * @param UpdateBatchAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBatchAPIRequest $request, Organization $organization)
    {
        /** @var Batch $batch */
        $batch = Batch::find($id);

        if (empty($batch)) {
            return $this->sendError('Batch not found');
        }

        $batch->fill($request->all());
        $batch->save();

        BatchUpdated::dispatch($batch);
        return $this->sendResponse($batch->toArray(), 'Batch updated successfully');
    }

    /**
     * Remove the specified Batch from storage.
     * DELETE /batches/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Organization $organization)
    {
        /** @var Batch $batch */
        $batch = Batch::find($id);

        if (empty($batch)) {
            return $this->sendError('Batch not found');
        }

        $batch->delete();
        BatchDeleted::dispatch($batch);
        return $this->sendSuccess('Batch deleted successfully');
    }
    public function preview($id, Organization $organization, Request $request)
    {
        /** @var Batch $batch */
        $batch = Batch::find($id);
        $has_been_batched = false;
        if (empty($batch)) {
            return $this->sendError('Batch not found');
        }

        if ($request->batchable_id != null) {
            $batch_items = \Hasob\FoundationCore\Models\BatchItem::where('batchable_id', $request->batchable_id)->where('batchable_type', $request->batchable_type)->where('batch_id', $batch->id)->get();

            if (count($batch_items) > 0) {
                $has_been_batched = true;
            }
        }

        return $this->sendResponse(['content' => $batch->getBatchPreview(), 'batch_details' => $batch->toArray(), 'has_been_batched' => $has_been_batched], 'Batch preview gotten successfully');

    }

    public function removeBatchItem($id, Organization $organization, Request $request)
    {
        /** @var Batch $batch */
        $batch = Batch::find($id);
        $has_been_batched = false;
        if (empty($batch)) {
            return $this->sendError('Batch not found');
        }

        $batch_items = \Hasob\FoundationCore\Models\BatchItem::where('batchable_id', $request->batchable_id)->where('batchable_type', $request->batchable_type)->where('batch_id', $batch->id)->delete();

        return $this->sendSuccess('Batch Item Removed Successfully deleted successfully');

    }
 

}
