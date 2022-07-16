<?php
namespace Hasob\FoundationCore;

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


class FoundationCoreSiteManagerService
{

    public function get_default_site(){

        $current_org = \FoundationCore::current_organization();
        if ($current_org == null){
            Log::debug("Current organization not set, cannot return default site");
        }

        $default_org_site_id = $current_org->artifact('default-site-id');
        if ($default_org_site_id != null){
            return \Hasob\FoundationCore\Models\Site::find($default_org_site_id)->first();
        }
        return null;
    }

    public function get_default_site_artifacts($type){

        $default_site = $this->get_default_site();
        if ($default_site != null){
            $artifacts = $default_site->site_artifacts;
            return $artifacts->filter(function ($value, $key) use ($type) {
                return strtolower($value->type) == $type;
            });
        }
        return [];
    }
    
    public function get_default_site_components($name=null){

        $default_site = $this->get_default_site();
        if ($default_site != null){
            if ($name == null){
                return $this->get_default_site_artifacts('component');

            } else {
                $artifacts = $default_site->site_artifacts;
                $component = $artifacts->first(function ($value, $key) use ($name) {
                    return (strtolower($value->type)=='component' && strtolower($value->headline)==strtolower($name));
                });
                return $component;
            }
        }
        return null;
    }
    
    public function get_default_site_menus($name=null){

        $default_site = $this->get_default_site();
        if ($default_site != null){
            if ($name == null){
                return $this->get_default_site_artifacts('menu-item');

            } else {
                $artifacts = $default_site->site_artifacts;
                $component = $artifacts->first(function ($value, $key) use ($name) {
                    return (strtolower($value->type)=='menu-item' && strtolower($value->headline)==strtolower($name));
                });
                return $component;
            }
        }
        return null;
    }

    public function get_default_site_attachments($name_prefix=null,$selected_file_types=null){

        $file_types = "jpg,png,jpeg,gif,svg";
        if ($selected_file_types != null){
            $file_types = $selected_file_types;
        }

        $default_site = $this->get_default_site();
        if ($default_site != null){

            $attachments = $default_site->get_attachments($file_types);
            if ($name_prefix != null){
                
                $filtered_attachments = array_filter($attachments, function ($value, $key) use ($name_prefix) {
                    return str_starts_with(strtolower($value->label), strtolower($name_prefix));
                }, ARRAY_FILTER_USE_BOTH);

                return $filtered_attachments;
            }
            return $attachments;
        }
        return [];
    }

}