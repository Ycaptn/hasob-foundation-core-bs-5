<?php

namespace Hasob\FoundationCore\Ldap;

use  Hasob\FoundationCore\Managers\OrganizationManager;
//use  Hasob\Ldap\User as LdapUser;
use LdapRecord\Models\OpenLDAP\User as LdapUser;
use Hasob\FoundationCore\Models\User as DatabaseUser;
use Spatie\Permission\Models\Role;

class AttributeHandler{


    public function handle(LdapUser $ldap, DatabaseUser $database)
    {
        $host = request()->getHost();
        $manager = new OrganizationManager();
        $organization = $manager->loadTenant($host);
        
        $groups = $ldap->groups()->get();
        $roles = []; 
        /* foreach ($groups as $key => $group) {
            # code...
            if(!empty(Role::where("name",$group->getFirstAttribute('cn'))->first())){
                $roles [] = $group->getFirstAttribute('cn');
            }
         
        } */
        dd("here");
        $database->syncRoles($roles);
  
        $database->first_name = $ldap->getFirstAttribute('givenname');
        $database->last_name = $ldap->getFirstAttribute('sn');
        $database->email = $ldap->getFirstAttribute('mail');
        $database->telephone = $ldap->getFirstAttribute('telephoneNumber');
        $database->organization_id = optional($organization)->id;
    }

}