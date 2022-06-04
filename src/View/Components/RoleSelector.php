<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

class RoleSelector extends Component
{

    public $control_id;
    public $role_user;
    public $roles;

    public function __construct($user, $roles=[])
    {
        $this->role_user = $user;
        $this->control_id = "rls_".time();
        $this->roles = Role::all();

        if ($roles!=null && count($roles)>0){
            $this->roles = Role::whereIn('name',$roles)->get();
        }
        
    }


    public function render()
    {
        return view('hasob-foundation-core::components.role-selector');
    }
}