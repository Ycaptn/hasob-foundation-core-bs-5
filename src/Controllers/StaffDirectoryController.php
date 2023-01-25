<?php

namespace Hasob\FoundationCore\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

use Hasob\FoundationCore\Models\Department;
use Hasob\FoundationCore\Models\User;


use Hasob\FoundationCore\Traits\ApiResponder;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Controllers\BaseController;


class StaffDirectoryController extends BaseController 
{

    public function index(Organization $org, Request $request){
        $current_user = Auth()->user();
        $cdv_deparment_staffs = new \Hasob\FoundationCore\View\Components\CardDataView(User::class, "hasob-foundation-core::staff_directory.card_view_item");
        $cdv_deparment_staffs->setDataQuery(['organization_id'=>$org->id,'is_disabled'=>false])
                        ->addDataOrder('ranking_ordinal','DESC')
                        ->setQueryRelationship(['department' => []])
                        ->setSearchFields(['first_name', 'middle_name', 'last_name', 'email', 'telephone'])
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(20)
                        ->setSearchPlaceholder('Search Staff');
            
        if(request()->expectsJSON()){
            return $cdv_deparment_staffs->render();
        }

        return view('hasob-foundation-core::staff_directory.card_view_index')
        ->with('current_user', $current_user)
        ->with('cdv_deparment_staffs', $cdv_deparment_staffs);
    }


}
 
