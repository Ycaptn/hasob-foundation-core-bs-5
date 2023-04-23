<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;

class Attacher extends Component
{
    public $control_id;
    public $attachable;
    public $button_label;
    public $button_class;
    public $attachment_label;

    public function __construct($attachable, $attachmentLabel="", $buttonClass="", $buttonLabel="")
    {
        $this->control_id = "arch_".time()."_".rand(10,20000);
        $this->attachable = $attachable;
        $this->button_label = $buttonLabel;
        $this->button_class = $buttonClass;
        $this->attachment_label = $attachmentLabel;
    }

    public function render()
    {
        return view('hasob-foundation-core::components.attacher');
    }
}