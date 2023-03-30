<?php

namespace Hasob\FoundationCore\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hasob\FoundationCore\Models\BatchItem;

use Hasob\FoundationCore\Events\BatchItemCreated;
use Hasob\FoundationCore\Events\BatchItemUpdated;
use Hasob\FoundationCore\Events\BatchItemDeleted;

use Hasob\FoundationCore\Requests\API\CreateBatchItemAPIRequest;
use Hasob\FoundationCore\Requests\API\UpdateBatchItemAPIRequest;

use Hasob\FoundationCore\Traits\ApiResponder;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;

/**
 * Class BatchItemController
 * @package Hasob\FoundationCore\Controllers\API
 */

class BatchItemAPIController extends AppBaseController
{

    use ApiResponder;

    /**
     * Display a listing of the BatchItem.
     * GET|HEAD /batchItems
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = BatchItem::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        
        if ($organization != null){
            $query->where('organization_id', $organization->id);
        }

        $batchItems = $this->showAll($query->get());

        return $this->sendResponse($batchItems->toArray(), 'Batch Items retrieved successfully');
    }

    /**
     * Store a newly created BatchItem in storage.
     * POST /batchItems
     *
     * @param CreateBatchItemAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateBatchItemAPIRequest $request, Organization $organization)
    {
        $input = $request->all();

        /** @var BatchItem $batchItem */
        $bachable_ids = explode(",",$request->batchable_id);
        $batch_items = \Hasob\FoundationCore\Models\BatchItem::whereIn('batchable_id', $bachable_ids)->where('batchable_type', $request->batchable_type)->where('batch_id', $request->batch_id)->get();
        if (count($batch_items) > 0) {
            return $this->sendError('This one or more Item has already been added to this batch', 200);
        }
        foreach ($bachable_ids  as $key => $bachable_id) {
            # code...
           $batchItem = BatchItem::create([
                'batch_id' => $request->batch_id,
                'batchable_type' => $request->batchable_type,
                'batchable_id' => $bachable_id,
                'organization_id' => $request->organization_id
            ]);
        }
        //BatchItemCreated::dispatch($batchItem);
        return $this->sendResponse($batchItem->toArray(), 'Batch Item saved successfully');
    }

    /**
     * Display the specified BatchItem.
     * GET|HEAD /batchItems/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        /** @var BatchItem $batchItem */
        $batchItem = BatchItem::find($id);

        if (empty($batchItem)) {
            return $this->sendError('Batch Item not found');
        }

        return $this->sendResponse($batchItem->toArray(), 'Batch Item retrieved successfully');
    }

    /**
     * Update the specified BatchItem in storage.
     * PUT/PATCH /batchItems/{id}
     *
     * @param int $id
     * @param UpdateBatchItemAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBatchItemAPIRequest $request, Organization $organization)
    {
        /** @var BatchItem $batchItem */
        $batchItem = BatchItem::find($id);

        if (empty($batchItem)) {
            return $this->sendError('Batch Item not found');
        }

        $batchItem->fill($request->all());
        $batchItem->save();
        
        BatchItemUpdated::dispatch($batchItem);
        return $this->sendResponse($batchItem->toArray(), 'BatchItem updated successfully');
    }

    /**
     * Remove the specified BatchItem from storage.
     * DELETE /batchItems/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Organization $organization)
    {
        /** @var BatchItem $batchItem */
        $batchItem = BatchItem::find($id);

        if (empty($batchItem)) {
            return $this->sendError('Batch Item not found');
        }

        $batchItem->delete();
        BatchItemDeleted::dispatch($batchItem);
        return $this->sendSuccess('Batch Item deleted successfully');
    }
}
