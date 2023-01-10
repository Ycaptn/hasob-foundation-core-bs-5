<?php

namespace Hasob\FoundationCore\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hasob\FoundationCore\Models\Announcement;

use Hasob\FoundationCore\Events\AnnouncementCreated;
use Hasob\FoundationCore\Events\AnnouncementUpdated;
use Hasob\FoundationCore\Events\AnnouncementDeleted;

use Hasob\FoundationCore\Requests\API\CreateAnnouncementAPIRequest;
use Hasob\FoundationCore\Requests\API\UpdateAnnouncementAPIRequest;

use Hasob\FoundationCore\Traits\ApiResponder;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;

/**
 * Class announcementController
 * @package Hasob\FoundationCore\Controllers\API
 */

class AnnouncementAPIController extends AppBaseController
{

    use ApiResponder;

    /**
     * Display a listing of the announcement.
     * GET|HEAD /announcementes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = Announcement::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        
        if ($organization != null){
            $query->where('organization_id', $organization->id);
        }

        $announcements = $this->showAll($query->get());

        return $this->sendResponse($announcements->toArray(), 'announcements retrieved successfully');
    }

    /**
     * Store a newly created announcement in storage.
     * POST /announcementes
     *
     * @param CreateannouncementAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateannouncementAPIRequest $request, Organization $organization)
    {
        $input = $request->all();

        /** @var Announcement $announcement */
        $announcement = Announcement::create($input);
        
        AnnouncementCreated::dispatch($announcement);
        return $this->sendResponse($announcement->toArray(), 'announcement saved successfully');
    }

    /**
     * Display the specified announcement.
     * GET|HEAD /announcementes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        /** @var Announcement $announcement */
        $announcement = Announcement::find($id);

        if (empty($announcement)) {
            return $this->sendError('Announcement not found');
        }

        return $this->sendResponse($announcement->toArray(), 'announcement retrieved successfully');
    }

    /**
     * Update the specified announcement in storage.
     * PUT/PATCH /announcementes/{id}
     *
     * @param int $id
     * @param UpdateAnnouncementAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAnnouncementAPIRequest $request, Organization $organization)
    {
        /** @var Announcement $announcement */
        $announcement = Announcement::find($id);

        if (empty($announcement)) {
            return $this->sendError('announcement not found');
        }

        $announcement->fill($request->all());
        $announcement->save();
        
        AnnouncementUpdated::dispatch($announcement);
        return $this->sendResponse($announcement->toArray(), 'announcement updated successfully');
    }

    /**
     * Remove the specified announcement from storage.
     * DELETE /announcementes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Organization $organization)
    {
        /** @var Announcement $announcement */
        $announcement = Announcement::find($id);

        if (empty($announcement)) {
            return $this->sendError('Announcement not found');
        }

        $announcement->delete();
        AnnouncementDeleted::dispatch($announcement);
        return $this->sendSuccess('Announcement deleted successfully');
    }
}
