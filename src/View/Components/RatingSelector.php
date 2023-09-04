<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class RatingSelector extends Component
{
    public $control_id;
    public $ratable;
    public $authCheck;
    public $usedServiceChecker;

    public function __construct($ratable, $authCheck, $usedServiceChecker)
    {
        $this->ratable = $ratable;
        $this->control_id = "rtl_".time();
        $this->authCheck = $authCheck;
        $this->usedServiceChecker = $usedServiceChecker;
    }

    public function render()
    {
        return view('hasob-foundation-core::components.rating-selector');
    }
}