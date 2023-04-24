<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;

class IconSelector extends Component
{
    public $control_id;
    public $artifactable;
    public $button_label;
    public $button_class;
    public $artifactable_label;

    public function __construct($artifactable, $artifactLabel="", $buttonClass="", $buttonLabel="")
    {
        $this->control_id = "ics_".time()."_".rand(10,20000);
        $this->artifactable = $artifactable;
        $this->button_label = $buttonLabel;
        $this->button_class = $buttonClass;
        $this->artifactable_label = $artifactLabel;
    }

    public function render()
    {
        return view('hasob-foundation-core::components.icon-selector');
    }
}