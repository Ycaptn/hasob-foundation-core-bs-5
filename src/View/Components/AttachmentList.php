<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;

class AttachmentList extends Component
{
    public $control_id;
    public $attachable;
    public $file_types;

    public function __construct($attachable, $fileTypes=null)
    {
        $this->control_id = "alr_".time()."_".rand(10,20000);
        $this->file_types = $fileTypes;
        $this->attachable = $attachable;
    }

    public function render()
    {
        return view('hasob-foundation-core::components.attachment-list');
    }
}