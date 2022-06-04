<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;

class RoleLister extends Component
{

    public $control_id;
    public $role_user;

    public function __construct($user)
    {
        $this->role_user = $user;
        $this->control_id = "rst_".time();
    }


    public function render()
    {
        return view('hasob-foundation-core::components.role-lister');
    }
}