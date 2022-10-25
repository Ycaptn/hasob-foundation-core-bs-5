<?php

namespace Hasob\FoundationCore\Controllers\API;

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
use Hasob\FoundationCore\Models\Ledger;
use Hasob\FoundationCore\Models\Comment;
use Hasob\FoundationCore\Models\Department;
use Hasob\FoundationCore\Models\Organization;
use Hasob\FoundationCore\Models\ChecklistTemplate;
use Hasob\FoundationCore\Controllers\BaseController;

class ChecklistAPIController extends BaseController
{

    public function get_filter_checklist(Organization $org, Request $request){
        $input = $request->all();
        $list_names_arr = $input['list_name'];
        $get_filtered_checklist = ChecklistTemplate::whereIn('list_name', $list_names_arr)
                ->orderBy('ordinal', 'ASC')
                ->get();
                
        return $this->sendResponse($get_filtered_checklist->toArray(), 'Pages retrieved successfully');
    }

    public function index(Organization $org, Request $request){}    
    public function update(Organization $org, Request $request){}
    public function edit(Organization $org, Request $request, $id){}
    public function show(Organization $org, Request $request, $id){}
    public function delete(Organization $org, Request $request, $id){}
}
