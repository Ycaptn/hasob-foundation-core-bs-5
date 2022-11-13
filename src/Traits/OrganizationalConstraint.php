<?php

namespace Hasob\FoundationCore\Traits;

use Illuminate\Support\Facades\Schema;
use Hasob\FoundationCore\Models\Organization;
use Hasob\FoundationCore\Managers\OrganizationManager;

trait OrganizationalConstraint {

    /**
     * alter eloquent query to only fetch records for the current tenant
     *
     * @var array
    */
    public function newQuery() {
        
        $query = parent::newQuery();

        $host = request()->getHost();
        $manager = new OrganizationManager();
        $organization = $manager->loadTenant($host);

        if ($organization != null){
            if(isset($this->table) && $this->table != null){
                $query = parent::newQuery()->where($this->table.'.organization_id', $organization->id);
            }else{
                $query = parent::newQuery()->where('organization_id', $organization->id); 
            }
        }

        if ($this->getConnection()
                ->getSchemaBuilder()
                ->hasColumn($this->getTable(), 'created_at')) {
            $query = $query->orderBy('created_at','ASC');
        }

        return $query;
    }
}