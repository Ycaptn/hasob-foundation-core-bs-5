<?php

namespace Hasob\FoundationCore\Controllers;

use Carbon;
use Session;
use Validator;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

use Hasob\FoundationCore\Models\User;
use Hasob\FoundationCore\Models\Site;
use Hasob\FoundationCore\Models\Comment;
use Hasob\FoundationCore\Models\Department;
use Hasob\FoundationCore\Models\Organization;

class SiteController extends BaseController
{

    public function index(Organization $org, Request $request){

        return view('hasob-foundation-core::sites.index')
                ->with('sites', Site::all_sites($org));
    }

	//Display the specific resource
    public function show(Organization $org, Request $request, $id){
        $current_user = Auth::user();
		
		$item = null;
        if (empty($id) == false){
            $item = Site::find($id);
        }

        if ($item == null){
			abort(404);
        }
		
		if ($request->expectsJson()){
			return self::createJSONResponse("ok","success",$item,200);
		}
		
        return view('hasob-foundation-core::sites.site-manager')
                    ->with('site', $item)
                    ->with('organization', $org)
                    ->with('current_user', $current_user);
    }

	//Display creation of a new resource
    public function create(Organization $org, Request $request){
	
		return view('hasob-foundation-core::.index')
				->with('organization', $org)
				->with('current_user', $current_user);
	}

	//Destroy the specific resource
    public function destroy(Organization $org, Request $request, $id){
		
		$item = null;
        if (empty($id) == false){
            $item = Site::find($id);
        }

        if ($item == null){
			abort(404);
        }
		
		$item->destroy();
	}

	//Update a specific resource
    public function update(Organization $org, Request $request, $id){
	
		$item = null;
        if (empty($id) == false){
            $item = Site::find($id);
        }

        if ($item == null){
			abort(404);
        }
		
		$item->save();
	}

	//Store a newly created resource
    public function store(Organization $org, Request $request){

        $current_user = Auth::user();

        $site = new Site();
        $site->site_name = $request->site_name;
        $site->description = $request->site_description;
        $site->organization_id = $org->id;
        $site->creator_user_id = $current_user->id;
        
        if (empty($request->site_path) == true){
            $site->site_path = strtolower(self::generateRandomCode(8));
        }

        if (empty($request->site_department) != false){
            $site->department_id = $request->site_department;
        }
        $site->save();

        return self::createJSONResponse("ok","success",$site,200);
    }

}
