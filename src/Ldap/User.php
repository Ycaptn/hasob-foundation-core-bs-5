<?php
namespace Hasob\FoundationCore\Ldap;

use LdapRecord\Models\Model;
use LdapRecord\Models\OpenLDAP\User as LdapUser;

class User extends LdapUser
{
    protected array $guard_name = ['api', 'web'];

    public static $objectClasses = [
        "inetOrgPerson", 
        "posixAccount", 
        "shadowAccount"
    ];
}