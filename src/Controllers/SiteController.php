<?php

namespace Hasob\FoundationCore\Controllers;

use Carbon;
use Session;
use Validator;

use Hasob\FoundationCore\Models\Page;
use Hasob\FoundationCore\Models\Site;

use Hasob\FoundationCore\Events\SiteCreated;
use Hasob\FoundationCore\Events\SiteUpdated;
use Hasob\FoundationCore\Events\SiteDeleted;

use Hasob\FoundationCore\Requests\CreateSiteRequest;
use Hasob\FoundationCore\Requests\UpdateSiteRequest;

use Hasob\FoundationCore\DataTables\SiteDataTable;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;

use Flash;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class SiteController extends BaseController
{

    public function index(Organization $org, SiteDataTable $siteDataTable)
    {
        $current_user = Auth()->user();
        $default_org_site = \FoundationCore::current_organization()->artifact('default-site-id');

        $cdv_sites = new \Hasob\FoundationCore\View\Components\CardDataView(Site::class, "hasob-foundation-core::sites.card_view_item", ['default_org_site'=>$default_org_site]);
        $cdv_sites->setDataQuery(['organization_id'=>$org->id])
                        ->setSearchFields(['site_name','description'])
                        ->addDataOrder('display_ordinal','DESC')
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(20)
                        ->setSearchPlaceholder('Search Sites');

        if (request()->expectsJson()){
            return $cdv_sites->render();
        }

        return view('hasob-foundation-core::sites.card_view_index')
                    ->with('current_user', $current_user)
                    ->with('default_org_site', $default_org_site)
                    ->with('months_list', BaseController::monthsList())
                    ->with('states_list', BaseController::statesList())
                    ->with('cdv_sites', $cdv_sites)
                    ->with('all_sites', Site::all());
    }

    public function create(Organization $org)
    {
        return view('hasob-foundation-core::pages.sites.create');
    }

    public function store(Organization $org, CreateSiteRequest $request)
    {
        $input = $request->all();

        /** @var Site $site */
        $site = Site::create($input);
        if (empty($request->site_path) == true){
            $site->site_path = strtolower(self::generateRandomCode(8));
        }
        $site->save();
        Flash::success('Site saved successfully.');

        SiteCreated::dispatch($site);
        return redirect(route('fc.sites.index'));
    }

    public function show(Organization $org, $id)
    {

        $current_user = Auth()->user();
        $site = Site::find($id);

        if (empty($site)) {
            return redirect(route('fc.sites.index'));
        }

        $default_org_site = \FoundationCore::current_organization()->artifact('default-site-id');

        return view('hasob-foundation-core::sites.show')
                    ->with('site', $site)
                    ->with('current_user', $current_user)
                    ->with('default_org_site', $default_org_site)
                    ->with('months_list', BaseController::monthsList())
                    ->with('states_list', BaseController::statesList())
                    ->with('all_sites', Site::all());
    }

    public function displaySite(Organization $org, $id)
    {
        $current_user = Auth()->user();
        $site = Site::find($id);
        if (empty($site)) {
            return redirect(route('dashboard'));
        }

        $default_org_site = \FoundationCore::current_organization()->artifact('default-site-id');

        return view('hasob-foundation-core::sites.display')
                ->with('site', $site)
                ->with('current_user', $current_user)
                ->with('default_org_site', $default_org_site)
                ->with('months_list', BaseController::monthsList())
                ->with('states_list', BaseController::statesList());
    }

    public function displayPage(Organization $org, $site_id, $page_id)
    {
        $page = Page::find($page_id);
        $site = Site::find($site_id);
        if (empty($site) || empty($page)) {
            return redirect(route('dashboard'));
        }

        return view('hasob-foundation-core::sites.display')
                    ->with('site', $site)
                    ->with('page', $page);
    }

    public function edit(Organization $org, $id)
    {
        /** @var Site $site */
        $site = Site::find($id);

        if (empty($site)) {
            Flash::error('Site not found');

            return redirect(route('fc.sites.index'));
        }

        return view('hasob-foundation-core::sites.edit')->with('site', $site);
    }

    public function update(Organization $org, $id, UpdateSiteRequest $request)
    {
        /** @var Site $site */
        $site = Site::find($id);

        if (empty($site)) {
            Flash::error('Site not found');

            return redirect(route('fc.sites.index'));
        }

        $site->fill($request->all());
        $site->save();

        Flash::success('Site updated successfully.');
        
        SiteUpdated::dispatch($site);
        return redirect(route('fc.sites.index'));
    }


    public function destroy(Organization $org, $id)
    {
        /** @var Site $site */
        $site = Site::find($id);

        if (empty($site)) {
            Flash::error('Site not found');

            return redirect(route('fc.sites.index'));
        }

        $site->delete();

        Flash::success('Site deleted successfully.');
        SiteDeleted::dispatch($site);
        return redirect(route('fc.sites.index'));
    }

}
