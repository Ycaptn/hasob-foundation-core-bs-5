<?php

namespace Hasob\FoundationCore\Controllers;

use Hasob\FoundationCore\Models\Support;

use Hasob\FoundationCore\Events\SupportCreated;
use Hasob\FoundationCore\Events\SupportUpdated;
use Hasob\FoundationCore\Events\SupportDeleted;

use Hasob\FoundationCore\Requests\CreateSupportRequest;
use Hasob\FoundationCore\Requests\UpdateSupportRequest;

use Hasob\FoundationCore\DataTables\SupportDataTable;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;

use Flash;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class SupportController extends BaseController
{
    /**
     * Display a listing of the support.
     *
     * @param SupportDataTable $supportDataTable
     * @return Response
     */
    public function index(Organization $org, SupportDataTable $supportDataTable)
    {
        $current_user = Auth()->user();

        $cdv_supports = new \Hasob\FoundationCore\View\Components\CardDataView(Support::class, "hasob-foundation-core::supports.card_view_item");
        $cdv_supports->setDataQuery(['organization_id'=>$org->id])
                        //->addDataGroup('label','field','value')
                        //->setSearchFields(['field_to_search1','field_to_search2'])
                        //->addDataOrder('display_ordinal','DESC')
                        //->addDataOrder('id','DESC')
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(20)
                        ->setSearchPlaceholder('Search support');

        if (request()->expectsJson()){
            return $cdv_supports->render();
        }

       $departments = \Hasob\FoundationCore\Models\Department::all();

        return view('hasob-foundation-core::supports.card_view_index')
                    ->with("departments",$departments)
                    ->with('current_user', $current_user)
                    ->with('months_list', BaseController::monthsList())
                    ->with('states_list', BaseController::statesList())
                    ->with('cdv_supports', $cdv_supports);

        /*
        return $supportDataTable->render('hasob-foundation-core::pages.supportes.index',[
            'current_user'=>$current_user,
            'months_list'=>BaseController::monthsList(),
            'states_list'=>BaseController::statesList()
        ]);
        */
    }

    /**
     * Show the form for creating a new support.
     *
     * @return Response
     */
    public function create(Organization $org)
    {
        return view('hasob-foundation-core::pages.supports.create');
    }

    /**
     * Store a newly created support in storage.
     *
     * @param CreatesupportRequest $request
     *
     * @return Response
     */
    public function store(Organization $org, CreateSupportRequest $request)
    {
        $input = $request->all();

        /** @var Support $support */
        $support = Support::create($input);

        //Flash::success('support saved successfully.');

        SupportCreated::dispatch($support);
        return redirect(route('fc.supports.index'));
    }

    /**
     * Display the specified support.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(Organization $org, $id)
    {
        /** @var support $support */
        $support = Support::find($id);

        if (empty($support)) {
            //Flash::error('support not found');

            return redirect(route('fc.supports.index'));
        }

        return view('hasob-foundation-core::supports.show')->with('support', $support);
    }

    /**
     * Show the form for editing the specified support.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Organization $org, $id)
    {
        /** @var Support $support */
        $support = Support::find($id);

        if (empty($support)) {
            //Flash::error('support not found');

            return redirect(route('fc.supports.index'));
        }

        return view('hasob-foundation-core::supports.edit')->with('support', $support);
    }

    /**
     * Update the specified support in storage.
     *
     * @param  int              $id
     * @param UpdatesupportRequest $request
     *
     * @return Response
     */
    public function update(Organization $org, $id, UpdateSupportRequest $request)
    {
        /** @var Support $support */
        $support = Support::find($id);

        if (empty($support)) {
            //Flash::error('support not found');

            return redirect(route('fc.supports.index'));
        }

        $support->fill($request->all());
        $support->save();

        //Flash::success('support updated successfully.');
        
        SupportUpdated::dispatch($support);
        return redirect(route('fc.supports.index'));
    }

    /**
     * Remove the specified support from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Organization $org, $id)
    {
        /** @var Support $support */
        $support = Support::find($id);

        if (empty($support)) {
            //Flash::error('support not found');

            return redirect(route('fc.supports.index'));
        }

        $support->delete();

        //Flash::success('support deleted successfully.');
        SupportDeleted::dispatch($support);
        return redirect(route('fc.supports.index'));
    }


}
