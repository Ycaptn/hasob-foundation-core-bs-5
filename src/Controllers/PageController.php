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
use Hasob\FoundationCore\Models\Page;
use Hasob\FoundationCore\Models\Department;
use Hasob\FoundationCore\Models\Organization;

class PageController extends BaseController
{

    public function index(Organization $org, Request $request){

        
    }
	//Display the specific resource
    public function show(Organization $org, Request $request, $id){
        $current_user = Auth::user();
		
		$item = null;
        if (empty($id) == false){
            $item = Page::find($id);
        }

        if ($item == null){
			abort(404);
        }
		
		if ($request->expectsJson()){
			return self::createJSONResponse("ok","success",$item,200);
		}
		
        return view('hasob-foundation-core::.index')
                    ->with('', $item)
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
            $item = Page::find($id);
        }

        if ($item == null){
			abort(404);
        }
		
		$item->delete();
        return self::createJSONResponse("ok","success",$item,200);
	}

	//Update a specific resource
    public function update(Organization $org, Request $request, $id){
	
		$item = null;
        if (empty($id) == false){
            $item = Page::find($id);
        }

        if ($item == null){
			abort(404);
        }
		
		$item->save();
        return self::createJSONResponse("ok","success",$item,200);
	}

	//Store a newly created resource
    public function store(Organization $org, Request $request){

        $current_user = Auth::user();

        $page = new Page();
        $page->site_id = $request->site_id;
        $page->page_name = $request->page_name;
        $page->organization_id = $org->id;
        $page->creator_user_id = $current_user->id;
        
        if (empty($request->page_path) == true){
            $page->page_path = strtolower(self::generateRandomCode(8));
        }

        $page->save();

        return self::createJSONResponse("ok","success",$page,200);

    }
}
