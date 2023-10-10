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

        if ($organization != null) {
            $query->where('organization_id', $organization->id);
        }

        $announcements = $this->showAll($query->get());

        return $this->sendResponse($announcements->toArray(), 'announcements retrieved successfully');
    }

    /**
     * Store a newly created announcement in storage.
     * POST /announcementes
     *
     * @param CreateAnnouncementAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAnnouncementAPIRequest $request, Organization $organization)
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

    public function createAnnouncement(Organization $org, Request $request){

        $options = json_decode($request->options, true);
        if (isset($options['headline']) == false || $options['headline'] == null || empty($options['headline'])) {
            $err_msg = ['The title must be provided.'];
            return self::createJSONResponse("fail", "error", $err_msg, 200);
        }
        if (isset($options['end_date']) == false || $options['end_date'] == null || empty($options['end_date'])) {
            $err_msg = ['The End date must be provided.'];
            return self::createJSONResponse("fail", "error", $err_msg, 200);
        }
        if (isset($options['content']) == false || $options['content'] == null || empty($options['content'])) {
            $err_msg = ['The Description must be provided.'];
            return self::createJSONResponse("fail", "error", $err_msg, 200);
        }
        if (isset($options['announceable_id']) == false || empty($options['announceable_id'])) {
            $err_msg = ['Invalid upload request.'];
            return self::createJSONResponse("fail", "error", $err_msg, 200);
        }
        if (isset($options['announceable_type']) == false || empty($options['announceable_type']) || class_exists($options['announceable_type']) == false) {
            $err_msg = ['Invalid upload request.'];
            return self::createJSONResponse("fail", "error", $err_msg, 200);
        }

        $announceable_type = $options['announceable_type']::find($options['announceable_id']);
        if ($announceable_type == null) {
            $err_msg = ['Invalid upload request.'];
            return self::createJSONResponse("fail", "error", $err_msg, 200);
        }

        $announceable = Announcement::create([
            'organization_id ' => $org->id,
            'headline' => $options['headline'],
            'end_date' => $options['end_date'],
            'content' => $options['content'],
            'creator_user_id' => Auth()->user()->id,
            'announceable_id' => $options['announceable_id'],
            'announceable_type' => $options['announceable_type'],
        ]);

        return self::createJSONResponse("ok", "success", $announceable, 200);
    }
}
