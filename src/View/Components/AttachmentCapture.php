<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;

class AttachmentCapture extends Component
{
    public $control_id;
    public $attachable;

    public function __construct($attachable)
    {
        $this->control_id = "atc_".time().rand(1000,5000);
        $this->attachable = $attachable;
    }

    public function render()
    {
        return view('hasob-foundation-core::components.attachment-capture');
    }
}