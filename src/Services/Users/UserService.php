<?php
namespace Hasob\FoundationCore\Services\Users;

use Hash;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

use Hasob\FoundationCore\Models\Site;
use Hasob\FoundationCore\Models\User;
use Hasob\FoundationCore\Models\Ledger;
use Hasob\FoundationCore\Models\Setting;
use Hasob\FoundationCore\Models\Department;
use Hasob\FoundationCore\Models\Organization;

use Hasob\FoundationCore\Managers\OrganizationManager;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;


/**
 * This service provides several user essential functions
 * If the Redis server is available, it will provide redis 
 * enabled functionality
 */
class UserService
{

    const REDIS_KEY_PREFIX = "fc-users";
    

    public function get_users(Organization $org = null, $attributes=array()){

    }

    private function redis_cache_load(Organization $org = null){

    }

    private function redis_cache_refresh(Organization $org = null){

    }

    public function redis_cache_initialize(Organization $org = null){

    }

    
    public function redis_cache_get(Organization $org = null, $key){

    }

    public function redis_cache_set(Organization $org = null, $key, $value){

    }

    public function redis_cache_remove(Organization $org = null, $key, $value){

    }



    public function register_user(
        $first_name,
        $last_name,
        $email_address,
        $phone_number,
        $company_name=null,
        $security_roles=[],
        $password=null,
        $physical_location=null
    ){

        //Check if the user being requested exists
        $zUser = \Hasob\FoundationCore\Models\User::where('email', $email_address)->first();
        if ($zUser != null){
            return $zUser; 
        }

        $current_organization = \FoundationCore::current_organization();
        $zUser = new \Hasob\FoundationCore\Models\User();
        $zUser->organization_id = $current_organization->id;
        $zUser->email = $email_address;
        $zUser->last_name = $last_name;
        $zUser->first_name = $first_name;
        $zUser->telephone = $phone_number;
        $zUser->physical_location = $company_name;
        $zUser->physical_location = $physical_location;

        $random_password = \Hasob\FoundationCore\Controllers\BaseController::generateRandomCode(9);
        if ($password != null){
            $password = $random_password;
        }
        $zUser->password = Hash::make($password);

        if (count($security_roles)>0){
            $zUser->syncRoles($security_roles);
        }

        $zUser->save();
        return $zUser;
    }



}