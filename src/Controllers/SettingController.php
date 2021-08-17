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
use Hasob\FoundationCore\Models\Setting;
use Hasob\FoundationCore\Models\Department;
use Hasob\FoundationCore\Models\Organization;

class SettingController extends BaseController
{

    //Display the specific resource
    public function show(Organization $org, Request $request, $id){
        $current_user = Auth::user();
        
        $item = null;
        if (empty($id) == false){
            $item = Setting::find($id);
        }

        if ($item == null){
            abort(404);
        }
        
        if ($request->expectsJson()){
            return self::createJSONResponse("ok","success",$item,200);
        }
        
        return $item;
    }

    //Destroy the specific resource
    public function destroy(Organization $org, Request $request, $id){
        
        $item = null;
        if (empty($id) == false){
            $item = Setting::find($id);
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
            $item = Setting::find($id);
        }

        if ($item == null){
            abort(404);
        }

        $item->key = $request->key;
        $item->value = $request->value;
        $item->group_name = $request->group_name;
        $item->save();

        return self::createJSONResponse("ok","success",$item,200);
    }

    //Store a newly created resource
    public function store(Organization $org, Request $request){

        $current_user = Auth::user();

        $item = new Setting();
        $item->key = $request->key;
        $item->value = $request->value;
        $item->group_name = $request->group_name;
        $item->organization_id = $org->id;
        $item->save();

        return self::createJSONResponse("ok","success",$item,200);
    }


}
