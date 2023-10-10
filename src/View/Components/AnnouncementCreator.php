<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;

class AnnouncementCreator  extends Component
{
    public $announceable;
    public $label;

    public function __construct($announceable, $label)
    {
        $this->announceable = $announceable;
        $this->label = $label;
    }

    public function render()
    {
        return view('hasob-foundation-core::components.announcement-creator');
    }
}