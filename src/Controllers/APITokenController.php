<?php

namespace Hasob\FoundationCore\Controllers;

use Hash;
use Carbon;
use Session;
use Validator;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Hasob\FoundationCore\Models\User;
use Hasob\FoundationCore\Models\Organization;
use Hasob\FoundationCore\DataTables\APITokenDataTable;

class APITokenController extends BaseController
{

    public function index(Organization $org, Request $request, APITokenDataTable $aPITokenDataTable)
    {
        $current_user = auth()->user();
        $aPITokenDataTable = new APITokenDataTable($org);

        if ($request->expectsJson()) {
            return $aPITokenDataTable->ajax();
        }

        $org_users = User::where('organization_id', $current_user->organization_id)->get();
        
        return view('hasob-foundation-core::api_tokens.index')
                ->with('org_users', $org_users)
                ->with('current_user', $current_user)
                ->with('dataTable', $aPITokenDataTable->html());        
    }

    public function show(Organization $org, Request $request, $id)
    {

    }

    public function edit(Organization $org, Request $request, $id)
    {
    
    }

    public function update(Organization $org, Request $request, $id)
    {
        
    }

    public function delete(Organization $org, Request $request, $id)
    {

    }

}
