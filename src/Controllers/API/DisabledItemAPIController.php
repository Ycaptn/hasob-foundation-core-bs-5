<?php

namespace Hasob\FoundationCore\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hasob\FoundationCore\Models\DisabledItem;

use Hasob\FoundationCore\Events\DisabledItemCreated;
use Hasob\FoundationCore\Events\DisabledItemUpdated;
use Hasob\FoundationCore\Events\DisabledItemDeleted;

use Hasob\FoundationCore\Requests\API\CreateDisabledItemAPIRequest;
use Hasob\FoundationCore\Requests\API\UpdateDisabledItemAPIRequest;

use Hasob\FoundationCore\Traits\ApiResponder;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;

/**
 * Class DisabledItemController
 * @package Hasob\FoundationCore\Controllers\API
 */

class DisabledItemAPIController extends AppBaseController
{

    use ApiResponder;

    /**
     * Display a listing of the DisabledItem.
     * GET|HEAD /disabledItems
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = DisabledItem::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        
        if ($organization != null){
            $query->where('organization_id', $organization->id);
        }

        $disabledItems = $this->showAll($query->get());

        return $this->sendResponse($disabledItems->toArray(), 'Disabled Items retrieved successfully');
    }

    /**
     * Store a newly created DisabledItem in storage.
     * POST /disabledItems
     *
     * @param CreateDisabledItemAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateDisabledItemAPIRequest $request, Organization $organization)
    {
        $input = $request->all();

        /** @var DisabledItem $disabledItem */
        $disabledItem = DisabledItem::create($input);
        
        DisabledItemCreated::dispatch($disabledItem);
        return $this->sendResponse($disabledItem->toArray(), 'Disabled Item saved successfully');
    }

    /**
     * Display the specified DisabledItem.
     * GET|HEAD /disabledItems/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        /** @var DisabledItem $disabledItem */
        $disabledItem = DisabledItem::find($id);

        if (empty($disabledItem)) {
            return $this->sendError('Disabled Item not found');
        }

        return $this->sendResponse($disabledItem->toArray(), 'Disabled Item retrieved successfully');
    }

    /**
     * Update the specified DisabledItem in storage.
     * PUT/PATCH /disabledItems/{id}
     *
     * @param int $id
     * @param UpdateDisabledItemAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDisabledItemAPIRequest $request, Organization $organization)
    {
        /** @var DisabledItem $disabledItem */
        $disabledItem = DisabledItem::find($id);

        if (empty($disabledItem)) {
            return $this->sendError('Disabled Item not found');
        }

        $disabledItem->fill($request->all());
        $disabledItem->save();
        
        DisabledItemUpdated::dispatch($disabledItem);
        return $this->sendResponse($disabledItem->toArray(), 'DisabledItem updated successfully');
    }

    /**
     * Remove the specified DisabledItem from storage.
     * DELETE /disabledItems/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Organization $organization)
    {
        /** @var DisabledItem $disabledItem */
        $disabledItem = DisabledItem::find($id);

        if (empty($disabledItem)) {
            return $this->sendError('Disabled Item not found');
        }

        $disabledItem->delete();
        DisabledItemDeleted::dispatch($disabledItem);
        return $this->sendSuccess('Disabled Item deleted successfully');
    }
}
