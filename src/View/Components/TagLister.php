<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;

class TagLister extends Component
{

    public $control_id;
    public $taggable;

    public function __construct($taggable)
    {
        $this->taggable = $taggable;
        $this->control_id = "tgl_".time();
    }


    public function render()
    {
        return view('hasob-foundation-core::components.tag-lister');
    }
}