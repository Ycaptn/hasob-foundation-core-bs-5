<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;

class AttachmentViewer extends Component
{
    public $attachable;

    public function __construct($attachable)
    {
        $this->attachable = $attachable;
    }

    public function render()
    {
        return view('hasob-foundation-core::components.attachment-viewer');
    }
}