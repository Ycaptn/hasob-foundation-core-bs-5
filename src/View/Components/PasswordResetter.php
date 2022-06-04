<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;

class PasswordResetter extends Component
{

    public $control_id;
    public $password_user;

    public function __construct($user)
    {
        $this->password_user = $user;
        $this->control_id = "pwd_rs_".time();
    }


    public function render()
    {
        return view('hasob-foundation-core::components.password-resetter');
    }
}