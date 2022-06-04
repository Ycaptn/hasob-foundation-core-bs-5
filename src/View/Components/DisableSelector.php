<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;

class DisableSelector extends Component
{
    public $control_id;
    public $disabled_item;

    public function __construct($disabledItem)
    {
        $this->disabled_item = $disabledItem;
        $this->control_id = "ddi_".time();
    }

    public function render()
    {
        return view('hasob-foundation-core::components.disable-selector');
    }
}