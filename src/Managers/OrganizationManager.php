<?php
namespace Hasob\FoundationCore\Managers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

use Hasob\FoundationCore\Models\Organization;


class OrganizationManager {
    
    private $tenant;
   
    public function setTenant(Organization $tenant) {
        $this->tenant = $tenant;
        return $this;
    }
    
    public function getTenant() {
        return $this->tenant;
    }
    
    public function loadTenant($identifier) {

        if (Schema::hasTable('fc_organizations') == false){
           Log::error("Unable to set Organization ID as organizations table doesn't exist on DB");
            return null;
        }

        if ($identifier == "127.0.0.1" || $identifier == "localhost"){

            //this is local development
            $default_org_id = env('DEFAULT_ORGANIZATION', null);

            if ($default_org_id != null){
                $tenant = Organization::find($default_org_id);

            }else{

                $tenant = Organization::where('is_local_default_organization', true)->first();
                if ($tenant) {
                    $default_org_id = $tenant->id;
                }
            }

            if ($tenant) {
                $this->setTenant($tenant);
                return $tenant;
            }
        }else {
            
            $tenant = Organization::query()->where('full_url', 'LIKE', "%{$identifier}%")->first();
            if ($tenant) {
                $this->setTenant($tenant);
                return $tenant;
            }
        }

        Log::error("Unable to set Organization ID from env or domain");
        return null;
    }

}