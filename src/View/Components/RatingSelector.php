<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;

class RatingSelector extends Component
{
    public $control_id;
    public $ratable;

    public function __construct($ratable)
    {
        $this->ratable = $ratable;
        $this->control_id = "rtl_".time();
    }

    public function render()
    {
        return view('hasob-foundation-core::components.rating-selector');
    }
}