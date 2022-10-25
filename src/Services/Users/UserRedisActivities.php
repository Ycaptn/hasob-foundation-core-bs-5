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
class UserRedisActivities
{

    const REDIS_CHANNEL = "fc-users";
    

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



}