<?php

namespace Hasob\FoundationCore\Traits;

use Hasob\FoundationCore\Models\Organization;
use Hasob\FoundationCore\Managers\OrganizationManager;

trait OrganizationalConstraint {

    /**
     * alter eloquent query to only fetch records for the current tenant
     *
     * @var array
    */
    public function newQuery() {
        
        $host = request()->getHost();
        $manager = new OrganizationManager();
        $organization = $manager->loadTenant($host);

        if ($organization != null){
            return parent::newQuery()->where('organization_id', $organization->id);
        }

        return parent::newQuery();
    }
}