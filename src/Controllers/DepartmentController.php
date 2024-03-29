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

use Hasob\FoundationCore\Requests\CreateDepartmentRequest;
use Hasob\FoundationCore\Requests\UpdateDepartmentRequest;
use Hasob\FoundationCore\Models\User;
use Hasob\FoundationCore\Models\Comment;
use Hasob\FoundationCore\Models\Department;
use Hasob\FoundationCore\Models\Organization;

class DepartmentController extends BaseController
{

    public function index(Organization $org, Request $request){


        $current_user = Auth()->user();

        $cdv_departments = new \Hasob\FoundationCore\View\Components\CardDataView(Department::class, "hasob-foundation-core::departments.department-item");
        $cdv_departments->setDataQuery(['organization_id'=>$org->id])
                        ->addDataGroup('All','deleted_at', null)
                        ->addDataGroup('Departments','parent_id', null)
                        ->addDataGroup('Units','is_unit', true)
                        ->setSearchFields(['long_name','key','email','physical_location'])
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(20)
                        ->setSearchPlaceholder('Search');

        if (request()->expectsJson()){
            return $cdv_departments->render();
        }

        return view('hasob-foundation-core::departments.index')
                    ->with('current_user', $current_user)
                    ->with('departments', Department::where('is_unit', false)->get())
                    ->with('cdv_departments', $cdv_departments);
    }

    //Display the specific resource
    public function show(Organization $org, Request $request, $id){
        $current_user = Auth::user();
        
        $item = null;
        if (empty($id) == false){
            $item = Department::find($id);
        }

        if ($item == null){
            if ($request->expectsJson()){
                return self::createJsonResponse("fail", "error", 'No department record was found.', 200);
            }

            abort(404);
        }
        
        if ($request->expectsJson()){
            return self::createJSONResponse("ok","success",$item,200);
        }
        
        //Load the site manager if the department has a site.
        $department_site = null;
        $department_sites = $item->sites();
        if ($department_sites!=null && count($department_sites)>=1){
            $department_site = $department_sites[0];
        }

        return view('hasob-foundation-core::departments.view')
                    ->with('department', $item)
                    ->with('organization', $org)
                    ->with('department_site', $department_site)
                    ->with('current_user', $current_user);
    }


    public function show_settings(Organization $org, Request $request, $id){
        $current_user = Auth::user();
        
        $item = null;
        if (empty($id) == false){
            $item = Department::find($id);
        }

        if ($item == null){
            abort(404);
        }

        $cdv_child_departments = new \Hasob\FoundationCore\View\Components\CardDataView(Department::class, "hasob-foundation-core::departments.unit-item");
        $cdv_child_departments->setDataQuery(['organization_id'=>$org->id, 'parent_id'=>$id])
                        ->addActionButton('Add Unit', 'fa fa-plus','#', 'btn-new-mdl-department-unit-modal', [])
                        //->addDataGroup('All','deleted_at', null)
                        //->addDataGroup('Departments','field', 'value')
                       // ->addDataGroup('Units','field','value')
                        ->setSearchFields(['long_name','key','email','physical_location'])
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(20)
                        ->setSearchPlaceholder('Search');

        $cdv_department_members = new \Hasob\FoundationCore\View\Components\CardDataView(Department::class, "hasob-foundation-core::departments.unit-item");
        $cdv_department_members->setDataQuery(['organization_id'=>$org->id, 'department_id'=>$id])
                        ->addActionButton('Add Member', 'fa fa-plus','#', 'btn-new-mdl-department-members', [])
                        //->addDataGroup('All','deleted_at', null)
                        //->addDataGroup('Departments','field','value')
                        //->addDataGroup('Units','field','value')
                        ->setSearchFields(['first_name', 'last_name'])
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(20)
                        ->setSearchPlaceholder('Search');

        if (request()->expectsJson()){
            return $cdv_child_departments->render();
        }

        //Load the site manager if the department has a site.
        $department_site = null;
        $department_sites = $item->sites();
        if ($department_sites!=null && count($department_sites)>=1){
            $department_site = $department_sites[0];
        }
         
        return view('hasob-foundation-core::departments.settings')
                    ->with('department', $item)
                    ->with('organization', $org)
                    ->with('current_user', $current_user)
                    ->with('department_site', $department_site)
                    ->with('cdv_child_departments', $cdv_child_departments)
                    ->with('cdv_department_members', $cdv_department_members);
    }

    public function processMemberSelection(Request $request, Organization $org, $member_id){

        $current_user = Auth()->user();
        if($current_user != null && !$current_user->hasAnyRole(['departments-admin', 'admin'])){
            return self::createJsonResponse("fail", "error", "You are not authorized to perform this action.", 200);
        }
        $member_ids = explode(",",$request->member_id);
        $selected_members = User::whereIn("id",$member_ids)->get();
        $selected_department = Department::find($request->department_id);

        if(count($selected_members) == 0 || count($member_ids) != count($selected_members)){
            return self::createJsonResponse("fail", "error", 'An invalid member(s) was selected.', 200);
        }
      
        if($selected_department == null){
            return self::createJsonResponse("fail", "error", "An invalid department was selected.", 200);
        }
        User::whereIn("id", $member_ids)->update([
            "department_id" =>$selected_department->id
        ]);
      
        return $this->sendResponse([],'Member selection has been saved');

    }

    public function processDepartmentUnitSave(Organization $org, CreateDepartmentRequest $request){
        $current_user = Auth::user();
        $department = new Department();
        $input = [
        'email' => $request->email,
        'is_unit' => false,
        'key' => self::generateRandomCode(8),
        'long_name' => $request->long_name,
        'telephone' => $request->telephone,
        'parent_id' => $request->parent_id,
        'physical_location' => $request->physical_location,
        'organization_id' => $org->id
         ];
        
        $department->parent()->create($input);

        return self::createJSONResponse("ok","success",$department,200);

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
            $item = Department::find($id);
        }

        if ($item == null){
            abort(404);
        }
        
        $item->delete();
        return self::createJSONResponse("ok","success",$item,200);
    }

    //Update a specific resource
    public function update(Organization $org, UpdateDepartmentRequest $request, $id){
    
        $item = null;
        if (empty($id) == false){
            $item = Department::find($id);
        }

        if ($item == null){
            abort(404);
        }

        $item->email = $request->email;
        $item->is_unit = $request->is_unit;
        $item->long_name = $request->long_name;
        $item->telephone = $request->telephone;
        $item->parent_id = $request->parent_id;
        $item->physical_location = $request->physical_location;
        $item->save();

        return self::createJSONResponse("ok","success",$item,200);
    }

    //Store a newly created resource
    public function store(Organization $org, CreateDepartmentRequest $request){

        $current_user = Auth::user();

        $department = new Department();
        $department->email = $request->email;
        $department->is_unit = $request->is_unit;
        $department->key = self::generateRandomCode(8);
        $department->long_name = $request->long_name;
        $department->telephone = $request->telephone;
        $department->parent_id = $request->parent_id;
        $department->physical_location = $request->physical_location;
        $department->organization_id = $org->id;
        $department->save();

        return self::createJSONResponse("ok","success",$department,200);

    }

    public function getAllDepartments(Organization $org, Request $request) {
        $departments = Department::paginate(10);

        return self::createJSONResponse("All Departments retrived successfully.", 'success', $departments, 200);
    }

    public function getSpecificDepartmentMembers(Organization $org, Request $request, $id) {
        $department = Department::with('members')->find($id);

        if (empty($department)) {
            return self::createJsonResponse("fail", "error", 'No department record was found.', 200);
        }

        return self::createJSONResponse("Department and Members record retrived successfully.", 'success', $department, 200);
    }

}
