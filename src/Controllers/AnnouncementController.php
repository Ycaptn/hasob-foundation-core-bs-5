<?php

namespace Hasob\FoundationCore\Controllers;

use Hasob\FoundationCore\Models\Announcement;

use Hasob\FoundationCore\Events\AnnouncementCreated;
use Hasob\FoundationCore\Events\AnnouncementUpdated;
use Hasob\FoundationCore\Events\AnnouncementDeleted;

use Hasob\FoundationCore\Requests\CreateAnnouncementRequest;
use Hasob\FoundationCore\Requests\UpdateAnnouncementRequest;

use Hasob\FoundationCore\DataTables\AnnouncementDataTable;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;

use Flash;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class AnnouncementController extends BaseController
{
    /**
     * Display a listing of the announcement.
     *
     * @param AnnouncementDataTable $announcementDataTable
     * @return Response
     */
    public function index(Organization $org, AnnouncementDataTable $announcementDataTable)
    {
        $current_user = Auth()->user();

        $cdv_announcements = new \Hasob\FoundationCore\View\Components\CardDataView(Announcement::class, "hasob-foundation-core::announcements.card_view_item");
        $cdv_announcements->setDataQuery(['organization_id'=>$org->id])
                        //->addDataGroup('label','field','value')
                        //->setSearchFields(['field_to_search1','field_to_search2'])
                        //->addDataOrder('display_ordinal','DESC')
                        //->addDataOrder('id','DESC')
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(20)
                        ->setSearchPlaceholder('Search announcement');

        if (request()->expectsJson()){
            return $cdv_announcements->render();
        }

        return view('hasob-foundation-core::announcements.card_view_index')
                    ->with('current_user', $current_user)
                    ->with('months_list', BaseController::monthsList())
                    ->with('states_list', BaseController::statesList())
                    ->with('cdv_announcements', $cdv_announcements);

        /*
        return $announcementDataTable->render('hasob-foundation-core::announcementes.index',[
            'current_user'=>$current_user,
            'months_list'=>BaseController::monthsList(),
            'states_list'=>BaseController::statesList()
        ]);
        */
    }

    /**
     * Show the form for creating a new announcement.
     *
     * @return Response
     */
    public function create(Organization $org)
    {
        return view('hasob-foundation-core::announcements.create');
    }

    /**
     * Store a newly created announcement in storage.
     *
     * @param CreateAnnouncementRequest $request
     *
     * @return Response
     */
    public function store(Organization $org, CreateAnnouncementRequest $request)
    {
        $input = $request->all();

        /** @var Announcement $announcement */
        $announcement = Announcement::create($input);

        //Flash::success('Announcement saved successfully.');

        AnnouncementCreated::dispatch($announcement);
        return redirect(route('fc.announcements.index'));
    }

    /**
     * Display the specified announcement.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(Organization $org, $id)
    {
        /** @var Announcement $announcement */
        $announcement = Announcement::find($id);

        if (empty($announcement)) {
            //Flash::error('announcement not found');

            return redirect(route('fc.announcements.index'));
        }

        return view('hasob-foundation-core::announcements.show')->with('announcement', $announcement);
    }

    /**
     * Show the form for editing the specified announcement.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Organization $org, $id)
    {
        /** @var Announcement $announcement */
        $announcement = Announcement::find($id);

        if (empty($announcement)) {
            //Flash::error('announcement not found');

            return redirect(route('fc.announcements.index'));
        }

        return view('hasob-foundation-core::announcements.edit')->with('announcement', $announcement);
    }

    /**
     * Update the specified announcement in storage.
     *
     * @param  int              $id
     * @param UpdateAnnouncementRequest $request
     *
     * @return Response
     */
    public function update(Organization $org, $id, UpdateAnnouncementRequest $request)
    {
        /** @var Announcement $announcement */
        $announcement = Announcement::find($id);

        if (empty($announcement)) {
            //Flash::error('announcement not found');

            return redirect(route('fc.announcements.index'));
        }

        $announcement->fill($request->all());
        $announcement->save();

        //Flash::success('announcement updated successfully.');
        
        AnnouncementUpdated::dispatch($announcement);
        return redirect(route('fc.announcements.index'));
    }

    /**
     * Remove the specified announcement from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Organization $org, $id)
    {
        /** @var a
         * Announcement $announcement */
        $announcement = Announcement::find($id);

        if (empty($announcement)) {
            //Flash::error('announcement not found');

            return redirect(route('fc.announcements.index'));
        }

        $announcement->delete();

        //Flash::success('announcement deleted successfully.');
        AnnouncementDeleted::dispatch($announcement);
        return redirect(route('fc.announcements.index'));
    }


}
